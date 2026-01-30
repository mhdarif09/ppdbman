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
        'nik',
        'full_name',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'phone',
        'photo',
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
        // Biodata fields
        'nickname',
        'nis',
        'religion',
        'nationality',
        'language',
        'child_order',
        'siblings_count',
        'half_siblings_count',
        'adopted_siblings_count',
        'child_status',
        'current_address',
        'whatsapp_number',
        'blood_type',
        'diseases',
        'allergies',
        'physical_defects',
        'height',
        'weight',
        'biodata_completed_at',
        'registration_step',
        'registration_completed_at',
        'documents_checklist',
        'verification_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime',
        'biodata_completed_at' => 'datetime',
        'registration_completed_at' => 'datetime',
        'total_score' => 'decimal:2',
        'diseases' => 'array',
        'documents_checklist' => 'array',
        'created_at' => 'datetime',

        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to generate registration number.
     */
    protected static function boot()
    {
        parent::boot();

        // Registration number is now generated when pathway is selected
    }

    /**
     * Generate unique registration number in official format.
     * Format: XXX/PMB/{PATHWAY}/YYYY
     */
    public static function generateRegistrationNumber(string $pathwayName): string
    {
        $year = date('Y');
        $lastApplicant = self::whereYear('created_at', $year)
            ->whereNotNull('registration_number')
            ->orderBy('id', 'desc')
            ->first();

        // Detect pathway suffix
        $pathwayType = \Illuminate\Support\Str::contains(strtoupper($pathwayName), 'PMPA') ? 'PMPA' : 'REGULER';

        $number = 1;
        if ($lastApplicant) {
            // Extract the first part (XXX)
            $parts = explode('/', $lastApplicant->registration_number);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $number = (int)$parts[0] + 1;
            }
        }

        return sprintf('%03d/PMB/%s/%s', $number, $pathwayType, $year);
    }

    /**
     * Generate unique verification token (UUID).
     */
    public static function generateVerificationToken(): string
    {
        return (string) \Illuminate\Support\Str::uuid();
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
    
    /**
     * Registration step relationships
     */
    public function education()
    {
        return $this->hasOne(ApplicantEducation::class);
    }
    
    public function parents()
    {
        return $this->hasOne(ApplicantParent::class);
    }
    
    public function hobby()
    {
        return $this->hasOne(ApplicantHobby::class);
    }
    
    public function development()
    {
        return $this->hasOne(ApplicantDevelopment::class);
    }
    
    public function grades()
    {
        return $this->hasMany(ApplicantGrade::class);
    }
}
