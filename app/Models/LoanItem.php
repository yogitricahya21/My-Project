<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanItem extends Model
{
     use HasFactory;

    protected $fillable = [
        'loan_id',
        'item_id',
        'quantity',
        'condition_on_loan',
        'condition_on_return',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
