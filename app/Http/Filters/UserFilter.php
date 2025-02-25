<?php

namespace App\Http\Filters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{

    public function id($id)
    {
        return $this->where('id', $id);
    }

    public function name($name)
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    public function email($email)
    {
        return $this->where('email', 'like', '%' . $email . '%');
    }
}
