<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $requests = DocumentRequest::with('resident', 'processor')->latest()->paginate(10);
        return view('documents.index', compact('requests'));
    }

    public function create()
    {
        $residents = Resident::all();
        return view('documents.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'document_type' => 'required|string',
            'purpose' => 'required|string',
        ]);

        DocumentRequest::create([
            'resident_id' => $request->resident_id,
            'document_type' => $request->document_type,
            'purpose' => $request->purpose,
            'status' => 'Pending',
        ]);

        return redirect()->route('documents.index')->with('success', 'Document request submitted successfully.');
    }

    public function show(DocumentRequest $document)
    {
        $document->load('resident', 'processor');
        return view('documents.show', compact('document'));
    }

    public function updateStatus(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Released,Rejected',
        ]);

        $documentRequest->update([
            'status' => $request->status,
            'processed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Document status updated successfully.');
    }

    public function destroy($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);
        $documentRequest->delete();

        return redirect()->route('documents.index')->with('success', 'Document request deleted successfully.');
    }
}