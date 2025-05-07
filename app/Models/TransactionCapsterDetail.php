<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCapsterDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo(Service::class)->where('id', $this->service_id);
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
