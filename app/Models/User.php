<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function error(){
        return $this->hasMany(Error::class, 'id_usuario');
    }

    public function budgetitemcut(){
        return $this->hasMany(BudgetItem::class, 'id', 'user_cut');
    }

    public function budgetitemedition(){
        return $this->hasMany(BudgetItem::class, 'id', 'user_edition');
    }

    public function budgetitemlayout(){
        return $this->hasMany(BudgetItem::class, 'id', 'user_layout');
    }

    public function budgetitemengraving(){
        return $this->hasMany(BudgetItem::class, 'id', 'user_engraving');
    }
}
