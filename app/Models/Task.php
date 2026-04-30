<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // ── Relations ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ── Accessor : est-ce que la date est dépassée ? ──
    public function isOverdue(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'done';
    }

    // ── Accessor : combien de jours restants ──
    public function daysLeft(): int|null
    {
        if (!$this->due_date) return null;
        return now()->startOfDay()->diffInDays($this->due_date->startOfDay(), false);
    }
}