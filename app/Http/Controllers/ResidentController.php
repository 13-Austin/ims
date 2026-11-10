<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $residents = Resident::all();
        return view('residents.index', compact('residents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('residents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'purok_sitio' => 'required|string',
            'employment_status' => 'nullable|string',
            'is_voter' => 'boolean',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'required|string',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Handle resident photo upload securely and flexibly
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            
            // I-store nang direkta sa public storage folder
            $file->storeAs('resident-photos', $filename, 'public');
            
            // I-save ang relative path sa validated array para pumasok sa database
            $validated['photo'] = 'resident-photos/' . $filename;
        }

        Resident::create($validated);

        return redirect()->route('residents.index')->with('success', 'Resident successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resident = Resident::findOrFail($id);
        return view('residents.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $resident = Resident::findOrFail($id);
        return view('residents.edit', compact('resident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'purok_sitio' => 'required|string',
            'employment_status' => 'nullable|string',
            'is_voter' => 'boolean',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'required|string',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $resident = Resident::findOrFail($id);

        // Panatilihin ang lumang photo kung walang bagong in-upload
        $validated['photo'] = $resident->photo;

        // Handle photo update and replacement kung may bagong file
        if ($request->hasFile('photo')) {
            if ($resident->photo && Storage::disk('public')->exists($resident->photo)) {
                Storage::disk('public')->delete($resident->photo);
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('resident-photos', $filename, 'public');
            
            $validated['photo'] = 'resident-photos/' . $filename;
        }

        $resident->update($validated);

        return redirect()->route('residents.index')->with('success', 'Resident information successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resident = Resident::findOrFail($id);

        // Delete associated photo file from storage upon deletion
        if ($resident->photo && Storage::disk('public')->exists($resident->photo)) {
            Storage::disk('public')->delete($resident->photo);
        }

        $resident->delete();

        return redirect()->route('residents.index')->with('success', 'Resident successfully deleted.');
    }
}