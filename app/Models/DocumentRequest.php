<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'document_type',
        'purpose',
        'status',
        'processed_by',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}