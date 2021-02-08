<?php

namespace App\Traits;

use App\Models\User;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait Upload
{
    private $photo, $image_path, $random_name;

    public function uploadImageOnLocal($data, $guard = WEB): ?string
    {
        $this->setData($data);

        if ($this->photo && $guard === WEB)
            return $this->webImageOnLocal();

        if ($this->photo && $guard === API)
            return $this->apiImageOnLocal();

        return null;
    }

    private function setData($data){

        $this->photo = isset($data['photo']) ? $data['photo'] : null;
        $this->image_path = isset($data['path']) ? $data['path'] : 'uploads';
        $this->random_name = random_int(0, 999) . time() . '.';
    }

    private function webImageOnLocal(): string
    {
        $image_name = $this->random_name.$this->photo->extension();
        $this->photo->storeAs($this->image_path, $image_name, ['disk' => 'public']);
        return $this->image_path.'/'.$image_name;
    }

    private function apiImageOnLocal(): string
    {
        $image_name = explode('/', explode(':', substr($this->photo, 0, strpos($this->photo, ';')))[1])[1];
        $image_url = $this->image_path.'/'.$this->random_name.$image_name;
        $photo = Image::make($this->photo);
        $photo->stream(); // <-- Key point
        Storage::disk('public')->put($image_url, $photo, 'public');

        return $image_url;
    }

    public static function uploadToAws($payload)
    {
        $file = isset($payload['image']) ? $payload['image'] : null;
        $image_path = isset($payload['path']) ? $payload['path'] : null;
        $image_url = null;

        if($file) {
            $user = User::find(getUserId());
            $user = $user->isAdmin() ? 'cayfoo' : Str::slug($user->full_name);

            $saveName = random_int(0, 999) . time() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];

            if($image_path !== null){
                $fullPath = $user. '/' .$image_path. '/' .$saveName;
            }else{
                $fullPath = $user. '/' .$saveName;
            }

            $base64Str = substr($file, strpos($file, ",") + 1);
            $image = base64_decode($base64Str);

            $path = Storage::disk('s3')->put(
                $fullPath, #$path
                $image,
                'public'
            );
            if ($path === true) {
                $image_url = 'https://test590.s3.eu-central-1.amazonaws.com/'.$fullPath;
            }
        }
        return $image_url;
    }
}
