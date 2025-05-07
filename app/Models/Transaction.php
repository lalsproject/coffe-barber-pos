<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Status Flag
    const CANCEL = 'cancel';
    const FAILED = 'failed';
    const PAID = 'paid';
    const UNPAID = "unpaid";

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
