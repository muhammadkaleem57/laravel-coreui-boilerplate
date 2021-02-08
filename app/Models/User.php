<?php

namespace App\Models;


use App\Traits\Logs;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, SoftDeletes;
    use Logs, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'uuid', 'type', 'added_by', 'parent_id', 'is_active',
        'verification_code', 'user_name', 'is_online'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFullNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? url('/storage/'.$this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->full_name).'&color=7F9CF5&background=EBF4FF';
    }

    // TODO: Change the autogenerated stub
    protected static function booted()
    {
        parent::booted();
        self::creating(function ($model) {
            $model->uuid = self::generateUUId($model);
            $model->verification_code = rand(100000, 999999);
            self::onCreating($model);
        });
        self::updating(function ($model) {
            self::onUpdating($model);
        });
    }

    public function isSuperAdmin()
    {
        return $this->attributes['is_super_admin'] === YES;
    }

    public function isAdmin()
    {
        return $this->attributes['type'] === ADMIN;
    }

    public function isUser()
    {
        return $this->attributes['type'] === USER;
    }

    public function isActive()
    {
        return $this->attributes['is_active'] === YES;
    }

    public function isOnline()
    {
        return $this->attributes['is_online'] === YES;
    }

    public function isAccountVerified()
    {
        return $this->attributes['email_verified_at'] === null ? false : true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', YES);
    }

}
