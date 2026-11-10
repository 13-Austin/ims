<?php

namespace App\Http\Controllers;

use App\Models\SkProject;
use Illuminate\Http\Request;

class SkProjectController extends Controller
{
    public function index()
    {
        $projects = SkProject::all();
        return view('sk.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget_allocated' => 'required|numeric',
            'target_date' => 'required|date',
        ]);

        SkProject::create([
            'project_name' => $request->project_name,
            'description' => $request->description,
            'budget_allocated' => $request->budget_allocated,
            'status' => 'Planned',
            'target_date' => $request->target_date,
        ]);

        return redirect()->back()->with('success', 'Bagong SK Project ay matagumpay na naidagdag.');
    }
}