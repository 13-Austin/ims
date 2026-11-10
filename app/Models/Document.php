<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'control_number',
        'resident_id',
        'document_type',
        'purpose',
        'status',
        'dry_seal_number',
        'signatory_name',
        'signatory_title',
        'processed_by',
        'approved_by',
        'issued_by',
        'approved_at',
        'issued_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'issued_at' => 'datetime',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}