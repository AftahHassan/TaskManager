<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'category_id',
    ];

    // 🔗 Relation : Task appartient à User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relation : Task appartient à Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
