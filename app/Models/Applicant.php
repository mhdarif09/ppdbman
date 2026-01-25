<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'ppdb_pathway_id',
        'nisn',
        'full_name',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'phone',
        'parent_name',
        'parent_phone',
        'registration_number',
        'status',
        'academic_year',
        'verified_at',
        'verified_by',
        'verification_notes',
        'rejection_reason',
        'total_score',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime',
        'total_score' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to generate registration number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($applicant) {
            if (empty($applicant->registration_number)) {
                $applicant->registration_number = self::generateRegistrationNumber();
            }
        });
    }

    /**
     * Generate unique registration number.
     */
    public static function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $lastApplicant = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastApplicant ? (int)substr($lastApplicant->registration_number, -5) + 1 : 1;
        return sprintf('PPDB%s%05d', $year, $number);
    }

    /**
     * Get the user that owns the application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pathway.
     */
    public function pathway(): BelongsTo
    {
        return $this->belongsTo(PpdbPathway::class, 'ppdb_pathway_id');
    }

    /**
     * Get the verifier.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'verified' => '<span class="badge badge-info">Terverifikasi</span>',
            'accepted' => '<span class="badge badge-success">Diterima</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '';
    }

    /**
     * Scope for pending applicants.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for verified applicants.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope for accepted applicants.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for rejected applicants.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope by pathway.
     */
    public function scopeByPathway($query, $pathwayId)
    {
        return $query->where('ppdb_pathway_id', $pathwayId);
    }

    /**
     * Scope by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope by academic year.
     */
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }
}
