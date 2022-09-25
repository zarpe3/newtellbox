<?php

namespace App\Models;

use App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'customer_id',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function scopeAccountCode($query, $accountCode)
    {
          return $query->whereHas('customer', function($q) use ($accountCode) {
              $q->getAccountCode($accountCode);
          });
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function profile() {
        //switch($this->customer->plan())
    }
}
