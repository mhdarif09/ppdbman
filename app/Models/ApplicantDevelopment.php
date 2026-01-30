<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantDevelopment extends Model
{
    protected $table = 'applicant_development';
    
    protected $fillable = [
        'applicant_id',
        'enrollment_year',
        'scholarships',
        'leave_year',
        'leave_reason',
        'graduation_year',
        'graduation_sttb_date',
        'graduation_sttb_number',
        'after_graduation_status',
        'continued_to',
        'working_at',
    ];
    
    protected $casts = [
        'graduation_sttb_date' => 'date',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
