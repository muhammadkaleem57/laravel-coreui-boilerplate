<?php

namespace App\Actions\Fortify;

use App\Traits\Upload;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    use Upload;
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'min:2', 'max:26'],
            'last_name' => ['required', 'string', 'min:2', 'max:26'],
            //'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $input['path'] = PROFILE_PHOTO_PATH;
            $user->profile_photo_path = $this->uploadImageOnLocal($input);
            //$user->updateProfilePhoto($input['photo']);
        }

        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->saveQuietly();
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
