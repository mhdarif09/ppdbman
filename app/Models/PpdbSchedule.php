<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'academic_year',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if schedule is currently active.
     */
    public function isActive(): bool
    {
        $now = now()->startOfDay();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if schedule is upcoming.
     */
    public function isUpcoming(): bool
    {
        return now()->startOfDay()->lt($this->start_date);
    }

    /**
     * Check if schedule is past.
     */
    public function isPast(): bool
    {
        return now()->startOfDay()->gt($this->end_date);
    }

    /**
     * Scope for current schedules.
     */
    public function scopeCurrent($query)
    {
        $now = now()->startOfDay();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    /**
     * Scope for upcoming schedules.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now()->startOfDay());
    }

    /**
     * Scope by academic year.
     */
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year',$year);
    }
}
