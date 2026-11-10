<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number',
        'complainant_name',
        'respondent_name',
        'incident_location',
        'incident_date',
        'complaint_details',
        'status',
        'hearing_date',
        'agreement_details',
        'recorded_by',
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}