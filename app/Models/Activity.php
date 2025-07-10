<?php

namespace App\Models;

use App\Models\ActivityCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'responsible_person',
        'attachments',
        'activity_category_id',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'attachments' => 'array', // Jika attachments disimpan sebagai JSON array
    ];

    public function activityCategory()
    {
        return $this->belongsTo(ActivityCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
