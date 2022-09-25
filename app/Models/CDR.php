<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CDR extends Model
{
    protected $table = 'cdr';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'accountCode',
        'uniqueid',
        'src',
        'dst',
        'start_date',
        'end_date',
        'rating',
        'billsec',
        'status',
        'audio'
    ];

    public function scopeAccountCode($query, $accountCode)
    {
        return $query->where('accountCode', $accountCode);
    }

}
