<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    public static $ImagePath = 'images/avatar/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $appends = [
        'avatar_full_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function avatarFullUrl(): Attribute
    {
        return new Attribute(
            get: fn () => is_null($this->avatar)
                ? asset('dist/images/avatar.png')
                : Storage::disk('public')->url($this->avatar)
        );
    }

    protected function roleName(): Attribute
    {
        return new Attribute(
            get: fn () => !empty($this->roles[0])
                ? $this->roles[0]->name
                : null
        );
    }


    protected function roleId(): Attribute
    {
        return new Attribute(
            get: fn () => !empty($this->roles[0])
                ? $this->roles[0]->id
                : null
        );
    }

    protected function isSadmin(): Attribute 
    {
        return new Attribute(
            get: fn () => $this->role_id === 1
        );
    }

    public function assigneds()
    {
        return $this->belongsToMany(Ticket::class, 'assigneds');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
