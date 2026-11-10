<?php

namespace App\Http\Controllers;

use App\Models\BlotterCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlotterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cases = BlotterCase::with('recorder')->latest()->paginate(10);
        return view('blotter.index', compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blotter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'case_number' => 'required|string|max:50|unique:blotter_cases,case_number',
            'complainant_name' => 'required|string|max:255',
            'respondent_name' => 'nullable|string|max:255',
            'incident_location' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'complaint_details' => 'required|string',
            'status' => 'required|string|max:50',
            'hearing_date' => 'nullable|date',
            'agreement_details' => 'nullable|string',
        ]);

        BlotterCase::create([
            'case_number' => $request->case_number,
            'complainant_name' => $request->complainant_name,
            'respondent_name' => $request->respondent_name,
            'incident_location' => $request->incident_location,
            'incident_date' => $request->incident_date,
            'complaint_details' => $request->complaint_details,
            'status' => $request->status,
            'hearing_date' => $request->hearing_date,
            'agreement_details' => $request->agreement_details,
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->route('blotter.index')->with('success', 'Ang Blotter Case ay matagumpay na na-save!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlotterCase $blotter)
    {
        return view('blotter.show', compact('blotter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlotterCase $blotter)
    {
        return view('blotter.edit', compact('blotter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlotterCase $blotter)
    {
        $request->validate([
            'case_number' => 'required|string|max:50|unique:blotter_cases,case_number,' . $blotter->id,
            'complainant_name' => 'required|string|max:255',
            'respondent_name' => 'nullable|string|max:255',
            'incident_location' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'complaint_details' => 'required|string',
            'status' => 'required|string|max:50',
            'hearing_date' => 'nullable|date',
            'agreement_details' => 'nullable|string',
        ]);

        $blotter->update($request->all());

        return redirect()->route('blotter.index')->with('success', 'Ang Blotter Case ay na-update na!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlotterCase $blotter)
    {
        $blotter->delete();
        return redirect()->route('blotter.index')->with('success', 'Ang Blotter Case ay natanggal na.');
    }
}