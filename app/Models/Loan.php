<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model {
    protected $fillable = ['amount', 'status', 'lender_id', 'borrower_id'];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';

    public function lender() {
        return $this->belongsTo(User::class, 'lender_id');
    }

    public function borrower() {
        return $this->belongsTo(User::class, 'borrower_id');
    }
}