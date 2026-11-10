<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->get();
        
        // Pagkalkula ng kabuuang pondo, nagastos, at variance para sa administrative decision making
        $totalAllocated = $projects->sum('allocated_budget');
        $totalSpent = $projects->sum('actual_spent');
        $budgetVariance = $totalAllocated - $totalSpent;

        return view('projects.index', compact('projects', 'totalAllocated', 'totalSpent', 'budgetVariance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|unique:projects,project_code|max:50',
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'allocated_budget' => 'required|numeric|min:0',
            'actual_spent' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'target_completion_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Planned,On-Going,Completed,Delayed',
            'purok_location' => 'required|string|max:255',
        ]);

        // Kung walang nilagay na actual_spent, gawing 0 by default
        $validated['actual_spent'] = $validated['actual_spent'] ?? 0;

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'project_code' => 'required|string|max:50|unique:projects,project_code,' . $project->id,
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'allocated_budget' => 'required|numeric|min:0',
            'actual_spent' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'target_completion_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Planned,On-Going,Completed,Delayed',
            'purok_location' => 'required|string|max:255',
        ]);

        $validated['actual_spent'] = $validated['actual_spent'] ?? 0;

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project information successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project successfully deleted.');
    }
}