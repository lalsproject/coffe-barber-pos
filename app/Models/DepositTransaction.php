<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositTransaction extends Model
{
    const CASH_IN = 'CASH_IN';
    const CASH_OUT = 'CASH_OUT';
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class)->where('id', $this->user_id);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class)->where('id', $this->branch_id);
    }
}
