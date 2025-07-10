<?php

namespace App\Models;

use App\Models\User;
use App\Models\LoanItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
     use HasFactory;

    protected $fillable = [
        'borrower_name',
        'borrower_department',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }
}
