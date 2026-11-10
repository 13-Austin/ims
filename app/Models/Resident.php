<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'gender',
        'civil_status',
        'purok_sitio',
        'employment_status',
        'is_voter',
        'contact_number',
        'address',
        'photo',
    ];

    /**
     * Relationship: A resident can have many document requests.
     */
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }
}