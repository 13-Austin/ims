<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DemographicController extends Controller
{
    public function index()
    {
        // 1. Kunin ang lahat ng residente para sa modal listahan
        $residents = Resident::all();
        $residentsList = $residents; // Para tugma sa view variable

        // 2. Total Population Count
        $totalPopulation = $residents->count();

        // 3. Gender Breakdown (Male vs Female)
        $maleCount = $residents->where('gender', 'Male')->count();
        $femaleCount = $residents->where('gender', 'Female')->count();

        // 4. Age Bracket Calculations (Minors, SK Age, Working Age, Senior Citizens)
        $minorsCount = 0;       // 0 - 14 years old
        $skCount = 0;           // 15 - 30 years old (Sangguniang Kabataan bracket)
        $workingCount = 0;      // 31 - 59 years old
        $seniorCount = 0;       // 60 and above

        foreach ($residents as $resident) {
            if ($resident->birthdate) {
                $age = Carbon::parse($resident->birthdate)->age;
                
                if ($age <= 14) {
                    $minorsCount++;
                } elseif ($age >= 15 && $age <= 30) {
                    $skCount++;
                } elseif ($age >= 31 && $age <= 59) {
                    $workingCount++;
                } else {
                    $seniorCount++;
                }
            }
        }

        // 5. Purok-Level Population Density (PurokStats para sa view)
        $purokStats = Resident::select('purok_sitio as purok_name', \DB::raw('count(*) as total'))
            ->whereNotNull('purok_sitio')
            ->where('purok_sitio', '!=', '')
            ->groupBy('purok_sitio')
            ->get();

        // 6. Civil Status Statistics (CivilStats para sa view)
        $civilStats = Resident::select('civil_status as status', \DB::raw('count(*) as total'))
                               ->whereNotNull('civil_status')
                               ->where('civil_status', '!=', '')
                               ->groupBy('civil_status')
                               ->get();

        // Ibalik ang lahat ng kinakailangang variables papunta sa view
        return view('demographics.index', compact(
            'residentsList',
            'totalPopulation',
            'maleCount',
            'femaleCount',
            'minorsCount',
            'skCount',
            'workingCount',
            'seniorCount',
            'purokStats',
            'civilStats'
        ));
    }
}