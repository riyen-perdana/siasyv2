<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'name',
        'glr_dpn',
        'glr_blk',
        'is_aktif',
        'jabatan',
        'email',
        'password',
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
     * Appended Attributes
     *
     * @var array
     */
    protected $appends = [
        'full_nm_user',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * getPermissionArray
     *
     * @return void
     */
    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr['name'] => true];
        });

    }

    /**
     * Mutator dan Accessor Field name
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value),
            get: fn (string $value) => ucwords($value)
        );
    }

    /**
     * Accessor full_nm_user
     * @var array
     */
    public function getFullNmUserAttribute()
    {
        if ($this->glr_dpn == NULL || strlen(trim($this->glr_dpn) == 0))
        {
            return "{$this->name}. {$this->glr_blk}";
        }
            elseif ($this->glr_blk == NULL || strlen(trim($this->glr_blk) == 0))
        {
            return "{$this->glr_dpn}. {$this->name}";
        }
            elseif (($this->glr_dpn != NULL || strlen(trim($this->glr_dpn) != 0)) && ($this->glr_blk != null || strlen(trim($this->glr_blk) != 0)))
        {
            return "{$this->glr_dpn}. {$this->name}.{$this->glr_blk}";
        } else
        {
            return "{$this->name}";
        }
    }


}
