<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PvSignature;
use Illuminate\Http\Request;

class PvController extends Controller
{
    public function index()
    {
        $pvs = PvSignature::with('session')->get();
        return view('admin.pv.index', compact('pvs'));
    }

    public function create()
    {
        return view('admin.pv.create');
    }

    public function show(PvSignature $pv)
    {
        return view('admin.pv.show', compact('pv'));
    }
}
