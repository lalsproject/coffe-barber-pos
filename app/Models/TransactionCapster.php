<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCapster extends Model
{
    use HasFactory;

    const CANCEL = 'cancel';
    const FAILED = 'failed';
    const PAID = 'paid';
    const UNPAID = "unpaid";
    protected $guarded = ['id'];

    public function capster()
    {
        return $this->belongsTo(Capster::class)->where('id', $this->capster_id);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->where('id', $this->user_id);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class)->where('id', $this->branch_id);
    }
}
