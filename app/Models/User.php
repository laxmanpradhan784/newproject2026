<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    // Hidden fields (for arrays/JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // In User model
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartCount()
    {
        return $this->cartItems()->sum('quantity');
    }

    public function cartTotal()
    {
        return $this->cartItems()->get()->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
