<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncementResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'applicant_id',
        'result',
        'rank',
    ];

    protected $casts = [
        'rank' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the announcement.
     */
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * Get the applicant.
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Scope by result.
     */
    public function scopeByResult($query, $result)
    {
        return $query->where('result', $result);
    }

    /**
     * Scope for accepted.
     */
    public function scopeAccepted($query)
    {
        return $query->where('result', 'accepted');
    }

    /**
     * Scope for rejected.
     */
    public function scopeRejected($query)
    {
        return $query->where('result', 'rejected');
    }
}
