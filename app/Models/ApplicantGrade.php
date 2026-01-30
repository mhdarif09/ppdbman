<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantGrade extends Model
{
    protected$fillable = [
        'applicant_id',
        'semester',
        'subject',
        'grade',
    ];
    
    protected $casts = [
        'grade' => 'decimal:2',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
