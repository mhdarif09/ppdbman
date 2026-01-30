<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    protected $table = 'applicant_education';
    
    protected $fillable = [
        'applicant_id',
        'previous_school_name',
        'school_name',
        'school_address',
        'school_type',
        'school_npsn',
        'sttb_number',
        'sttb_date',
        'study_duration',
        'is_transfer',
        'transfer_from_grade',
        'transfer_from_school',
        'transfer_class',
        'transfer_date',
        'transfer_program',
        'transfer_reason',
    ];
    
    protected $casts = [
        'sttb_date' => 'date',
        'transfer_date' => 'date',
        'is_transfer' => 'boolean',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
