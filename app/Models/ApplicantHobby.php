<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantHobby extends Model
{
    protected $fillable = [
        'applicant_id',
        'arts',
        'sports',
        'organization',
        'other',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
