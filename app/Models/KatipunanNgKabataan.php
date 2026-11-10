<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatipunanNgKabataan extends Model
{
    use HasFactory;

    // Tahasan nating ituro dito na may 's' sa dulo ang table sa database
    protected $table = 'katipunan_ng_kabataans';

    protected $fillable = [
        'resident_id',
        'youth_classification',
        'educational_background',
        'is_registered_voter',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}