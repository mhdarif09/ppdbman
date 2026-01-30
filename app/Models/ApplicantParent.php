<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantParent extends Model
{
    protected $fillable = [
        'applicant_id',
        'father_name', 'father_nik', 'father_birth_place', 'father_birth_date',
        'father_religion', 'father_nationality', 'father_education',
        'father_occupation', 'father_job', 'father_income', 'father_address',
        'father_phone', 'father_whatsapp', 'father_status',
        'mother_name', 'mother_nik', 'mother_birth_place', 'mother_birth_date',
        'mother_religion', 'mother_nationality', 'mother_education',
        'mother_occupation', 'mother_job', 'mother_income', 'mother_address',
        'mother_phone', 'mother_whatsapp', 'mother_status',
        'guardian_name', 'guardian_job', 'guardian_birth_place', 'guardian_birth_date',
        'guardian_religion', 'guardian_nationality', 'guardian_education',
        'guardian_occupation', 'guardian_income', 'guardian_address',
        'guardian_phone', 'guardian_whatsapp',
    ];
    
    protected $casts = [
        'father_birth_date' => 'date',
        'mother_birth_date' => 'date',
        'guardian_birth_date' => 'date',
        'father_income' => 'decimal:2',
        'mother_income' => 'decimal:2',
        'guardian_income' => 'decimal:2',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
