<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'usercode',
        'username',
        'email',
        'dept_id',
        'password',
        'status',
        'active',
        'stksite'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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

    public function getCardIdAttribute()
    {
        return TblPerson::select('card_id')->where('pid', $this->pid)->first()->card_id;
    }

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', $this->dept_id)->value('dept_name');
    }

    public function getStatusNameAttribute()
    {
        return UserStatus::where('id', $this->status)->value('status_name');
    }

    public function getIdCryptAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    public function getPhotoUrlAttribute()
    {
        return env('BACKOFFICE_IMAGE').base64_encode(env('IMG_KEY').base64_encode($this->card_id));
    }

    public function depts()
    {
        return $this->hasMany(UserDept::class);
    }

    public function documents()
    {
        return $this->hasMany(UserDoctype::class); 
    }

    public function getGroupIdsAttribute()
    {
        return StkgrpsUser::where('usercode', $this->usercode)->pluck('stkgroup');
    }
}
