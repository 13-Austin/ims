<?php

namespace App\Http\Controllers;

use App\Models\KatipunanNgKabataan;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // 1. I-import ang Rule class sa itaas o gamitin diretso

class KatipunanNgKabataanController extends Controller
{
    public function index()
    {
        $kkMembers = KatipunanNgKabataan::with('resident')->get();
        
        $eligibleResidents = Resident::whereRaw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN 15 AND 30")
            ->get();

        return view('sk.katipunan.index', compact('kkMembers', 'eligibleResidents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 2. Gamitin ang Rule::unique na direktang kumukuha sa Table ng Model para maiwasan ang typo/mismatch
            'resident_id' => [
                'required',
                'exists:residents,id',
                Rule::unique(KatipunanNgKabataan::class, 'resident_id'),
            ],
            'youth_classification' => 'nullable|string',
            'educational_background' => 'nullable|string',
            'is_registered_voter' => 'boolean',
        ]);

        KatipunanNgKabataan::create([
            'resident_id' => $request->resident_id,
            'youth_classification' => $request->youth_classification,
            'educational_background' => $request->educational_background,
            'is_registered_voter' => $request->has('is_registered_voter'),
        ]);

        return redirect()->back()->with('success', 'Successfully added to the Katipunan ng Kabataan Registry.');
    }
}