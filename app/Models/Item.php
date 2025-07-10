<?php

namespace App\Models;

use App\Models\Category;
use App\Models\LoanItem;
use App\Models\StorageLocation;
use App\Models\InboundTransaction;
use App\Models\OutboundTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
     use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'unit',
        'initial_stock',
        'current_stock',
        'price',
        'image',
        'category_id',
        'storage_location_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function inboundTransactions()
    {
        return $this->hasMany(InboundTransaction::class);
    }

    public function outboundTransactions()
    {
        return $this->hasMany(OutboundTransaction::class);
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }
}
