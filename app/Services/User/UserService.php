<?php

namespace App\Services\User;

use App\Events\Notification\NotificationEvent;
use App\Exceptions\CustomException;
use App\Http\Filters\UserFilter;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    use ImageHelper;

    public function index(Request $request)
    {
        $users = User::query()->filter($request->all(), UserFilter::class);
        $data = UserResource::collection($users->paginate())->response()->getData('true');
        return $data;
    }

    public function create(Request $request)
    {
        $user = DB::transaction(function () use ($request) {

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->save();

            //save user Image
            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->image, 'banner', false);
                $user->image()->create(['path' => $path]);
            }

            //assign roles if coming in request must be an array i.e ['admin','user']
            if ($request->roles) {
                $user->assignRole($request->roles);
            }

            return $user;
        });

        //trigger notification for new user
        NotificationEvent::dispatch($user);

        return new UserResource($user);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            throw new CustomException('User not found');
        }
        return $data = new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            throw new CustomException('User not found');
        }

        $user = DB::transaction(function () use ($request, $user) {
            //update user
            if ($request->has('password') && $request->password != '') {
                $user->password = bcrypt($request->password);
            }

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('username')) {
                $user->username = $request->username;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('phone') && $user->phone != $request->phone) {
                //$user->phone = $request->phone; //disabled
            }

            $user->save();

            //save user Image
            if ($request->hasFile('image')) {
                $oldImagePath = $user->image;
                $path = $this->updateFile($request->image, $oldImagePath, 'user', false);
                $user->image()->create(['path' => $path]);
            }

            // attach roles
            if ($request->roles) {
                $user->syncRoles($request->roles);
            }

            return $user;
        });

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            throw new CustomException('User not found');
        }
        $user->delete();
        return true;
    }

}
