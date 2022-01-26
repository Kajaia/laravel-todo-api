<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'list_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
