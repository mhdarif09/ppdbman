<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantCompetition extends Model
{
    protected $fillable = [
        'applicant_id',
        'competition_name',
        'year',
        'level',
    ];
    
    protected $casts = [
        'year' => 'integer',
    ];
    
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
