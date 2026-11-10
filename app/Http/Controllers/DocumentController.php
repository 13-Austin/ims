<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Resident;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $requests = Document::with(['resident', 'processor', 'approver', 'issuer'])->latest()->paginate(10);
        return view('documents.index', compact('requests'));
    }

    public function create()
    {
        $residents = Resident::orderBy('last_name')->get();
        return view('documents.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'document_type' => 'required|string',
            'purpose' => 'nullable|string',
        ]);

        $controlNumber = 'MAGS-' . date('Y') . '-' . str_pad(Document::count() + 1, 4, '0', STR_PAD_LEFT);

        Document::create([
            'control_number' => $controlNumber,
            'resident_id' => $request->resident_id,
            'document_type' => $request->document_type,
            'purpose' => $request->purpose,
            'status' => 'Pending',
            'processed_by' => auth()->id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document request created successfully.');
    }

    // Approval & Signatory Workflow Handler
    public function updateStatus(Request $request, Document $document)
    {
        // 1. Backend Security: I-block si Staff kung sakaling subukan nitong mag-approve
        if (auth()->user()->role === 'Staff') {
            return redirect()->back()->with('error', 'Unauthorized action. Staff members are not allowed to approve documents.');
        }

        $request->validate([
            'status' => 'required|in:Pending,Approved,Released,Rejected',
            'dry_seal_number' => 'nullable|string',
            'signatory_name' => 'required_if:status,Approved,Released|string',
            'signatory_title' => 'required_if:status,Approved,Released|string',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'Approved') {
            $data['approved_by'] = auth()->id();
            $data['approved_at'] = now();
            $data['signatory_name'] = $request->signatory_name;
            $data['signatory_title'] = $request->signatory_title;
        }

        if ($request->status === 'Released') {
            $data['issued_by'] = auth()->id();
            $data['issued_at'] = now();
            
            // 2. AUTOMATIC DRY SEAL TRACKING NO. INCREMENT (DS-YYYY-001)
            if (empty($request->dry_seal_number)) {
                $latestId = Document::max('id') ?? 0;
                $nextNum = $latestId + 1;
                $data['dry_seal_number'] = 'DS-' . date('Y') . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            } else {
                $data['dry_seal_number'] = $request->dry_seal_number;
            }
        }

        $document->update($data);

        return redirect()->back()->with('success', 'Document status and approval details updated successfully.');
    }

    // Print / Printable Template View
    public function show(Document $document)
    {
        // 3. PRINT / VIEW PROTECTION: Bawal i-view o i-print ni staff kung hindi pa Approved o Released
        if (auth()->user()->role === 'Staff' && !in_array($document->status, ['Approved', 'Released'])) {
            return redirect()->route('documents.index')->with('error', 'Hindi maaaring i-print o i-view ang dokumentong ito hangga’t hindi pa ito aprubado ni Kapitan o Admin.');
        }

        $document->load(['resident', 'processor', 'approver', 'issuer']);
        return view('documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        if (auth()->user()->role === 'Staff') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document request deleted successfully.');
    }
}