<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionDocument;
use App\Models\ExamSession;
use Illuminate\Http\Request;

class SessionDocumentController extends Controller
{
    public function store(Request $request, ExamSession $examSession)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|max:2048',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        SessionDocument::create([
            'exam_session_id' => $examSession->id,
            'title' => $request->title,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Document ajouté avec succès.');
    }

    public function destroy(SessionDocument $document)
    {
        if (file_exists(storage_path('app/public/' . $document->file_path))) {
            unlink(storage_path('app/public/' . $document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }
}
