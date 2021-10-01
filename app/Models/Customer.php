<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // verify email expired after 1 day
    const TIME_VERIFY_ACCOUNT = 86400;
    const EMAIL_VERIFY = 1;
    const ROLE3D = [
        1 => 'Interior Coordinator',
        2 => 'Sale',
        3 => 'Customer',
    ];
    const ACTIVE = 1;
    const DEACTIVE = 0;
    const ROLE_3D_COORDINATOR = 1;
    const ROLE_3D_SALE = 2;
    const ROLE_3D_CUSTOMER = 3;
    const SEND_ANNOUNCEMENT = 1;
    const CONDITION_MIN = '下限なし';
    const CONDITION_MAX = '上限なし';
    const FIRST_ANNOUNCEMENT = 1;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'email_verified_at',
        'social',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Validate the password of the user for the Passport password grant.
     *
     * @param string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }
}