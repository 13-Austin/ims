<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code',
        'project_name',
        'description',
        'allocated_budget',
        'actual_spent',
        'start_date',
        'target_completion_date',
        'status',
        'purok_location',
    ];
}