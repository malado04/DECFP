<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')->latest()->get();
        return view('admin.audit.index', compact('logs'));

    }

    public function show(AuditLog $audit)
    {
        return view('admin.audit.show', compact('audit'));

    }
}
