<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpdbPathway extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'quota',
        'filled',
        'is_active',
        'academic_year',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quota' => 'integer',
        'filled' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get applicants for this pathway.
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Get quota progress percentage.
     */
    public function getQuotaProgressAttribute(): float
    {
        if ($this->quota == 0) {
            return 0;
        }
        return min(($this->filled / $this->quota) * 100, 100);
    }

    /**
     * Get remaining quota.
     */
    public function getRemainingQuotaAttribute(): int
    {
        return max($this->quota - $this->filled, 0);
    }

    /**
     * Scope for active pathways.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by academic year.
     */
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }
}
