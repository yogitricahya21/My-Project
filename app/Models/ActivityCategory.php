<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityCategory extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'description'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
