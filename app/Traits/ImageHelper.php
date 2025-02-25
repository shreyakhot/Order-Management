<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


trait ImageHelper
{
    use MimeToExtensionHelper;

    public $publicPath = "/public/uploads/";
    public $storagePath = "/storage/uploads/";

    public function uploadFile($file, $prefix, bool $isEncoded = false)
    {
        if ($isEncoded) {
            $file = $this->createFileFromBase64($file);
        }
        $imagePath = '';
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = $prefix . '_' . Str::random(30) . '.' . $extension;
            $url = $file->storeAs($this->publicPath, $fileName);
            $publicPath = public_path($this->storagePath . $fileName);
            $img = Image::make($publicPath);
            $url = str_replace("public", "", $url);
            $imagePath = $img->save($publicPath) ? $url : '';
        }
        return $imagePath;
    }

    public function createFileFromBase64($base64File)
    {
        $fileData = base64_decode(Arr::last(explode(',', $base64File)));

        //Get MimeType
        $fileInfo = finfo_open();
        $mimeType = finfo_buffer($fileInfo, $fileData, FILEINFO_MIME_TYPE);

        //Get Extension from MimeType
        $ext = $this->mime2ext($mimeType);

        // save it to temporary dir first.
        // save it to temporary dir first.
        $tempFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString() . '.' . $ext;

        file_put_contents($tempFilePath, $fileData);

        $tempFileObject = new File($tempFilePath);
        return new UploadedFile(
            $tempFileObject->getPathname(),
            $tempFileObject->getFilename(),
            $tempFileObject->getMimeType(),
            0,
            true
        );
    }

    public function getFileFullUrl($path)
    {
        if ($path) {
            return App::make('url')->to('/') . '/storage' . $path;
        }
        return null;
    }

    public function updateFile($file, $existingFilePath, $prefix, bool $isEncoded)
    {
        $this->deleteFile($existingFilePath);
        return $this->uploadFile($file, $prefix, $isEncoded);
    }

    public function deleteFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            // Success! The file was deleted
        }
        return false;
    }

}
