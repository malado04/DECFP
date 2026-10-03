<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateDocument;
use Illuminate\Http\Request;

class CandidateDocumentController extends Controller
{
    public function index()
    {
        $documents = CandidateDocument::all();
        return view('admin.candidate_documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.candidate_documents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'candidate_id'=>'required|exists:candidates,id',
            'type'=>'required|string',
            'file_path'=>'required|string',
        ]);

        CandidateDocument::create($data);
        return redirect()->route('admin.candidate_documents.index')->with('success','Document créé');
    }

    public function show(CandidateDocument $candidate_document)
    {
        return view('admin.candidate_documents.show', compact('candidate_document'));
    }

    public function edit(CandidateDocument $candidate_document)
    {
        return view('admin.candidate_documents.edit', compact('candidate_document'));
    }

    public function update(Request $request, CandidateDocument $candidate_document)
    {
        $data = $request->validate([
            'candidate_id'=>'required|exists:candidates,id',
            'type'=>'required|string',
            'file_path'=>'required|string',
        ]);

        $candidate_document->update($data);
        return redirect()->route('admin.candidate_documents.index')->with('success','Document mis à jour');
    }

    public function destroy(CandidateDocument $candidate_document)
    {
        $candidate_document->delete();
        return redirect()->route('admin.candidate_documents.index')->with('success','Document supprimé');
    }

    public function indexForSession($session)
    {
        $documents = CandidateDocument::whereHas('candidate', function($q) use($session){
            $q->where('exam_session_id', $session->id);
        })->get();

        return view('admin.candidate_documents.index', compact('documents'));
    }
}
