<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'accountcode',
        'plan'
    ];

    public function scopeGetAccountCode($query, $accountCode)
    {
        return $query->where('accountcode', $accountCode);
    }

}
