<?php

namespace App\Http\Controllers;

use App\Models\SkBudget;
use Illuminate\Http\Request;

class SkBudgetController extends Controller
{
    public function index()
    {
        $budgets = SkBudget::all();
        return view('sk.budget.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fiscal_year' => 'required|digits:4',
            'total_allocation' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        SkBudget::create([
            'fiscal_year' => $request->fiscal_year,
            'total_allocation' => $request->total_allocation,
            'total_expenditure' => 0,
            'remaining_balance' => $request->total_allocation,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Matagumpay na naitala ang SK 10% Fund Allocation.');
    }
}