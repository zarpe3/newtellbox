<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipRoutes extends Model
{
    use HasFactory;

    public function scopeAccountcode($query, $accountCode)
    {
        return $query->where('accountcode', $accountCode);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
