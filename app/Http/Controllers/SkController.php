<?php

namespace App\Http\Controllers;

use App\Models\KatipunanNgKabataan;
use App\Models\SkProject;
use App\Models\SkBudget;
use Illuminate\Http\Request;

class SkController extends Controller
{
    public function index()
    {
        $totalKKMembers = KatipunanNgKabataan::count();
        $totalProjects = SkProject::count();
        $totalBudget = SkBudget::sum('total_allocation');
        $remainingBalance = SkBudget::sum('remaining_balance');

        return view('sk.dashboard', compact('totalKKMembers', 'totalProjects', 'totalBudget', 'remainingBalance'));
    }
}