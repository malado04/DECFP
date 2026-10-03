<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('exam')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $exams = Exam::all();

        $centerId = auth()->user()->center_id;

        $groups = Group::where('center_id', $centerId)
                       ->orderBy('order')
                       ->get();

        return view('admin.competencies.create', compact('exams', 'groups'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'name'    => 'required|string|max:255',
            'order'   => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // 1) créer sans code
            $group = Group::create([
                'exam_id' => $request->exam_id,
                'name'    => $request->name,
                'order'   => $request->order ?? 0,
            ]);

            // 2) générer et sauvegarder le code basé sur l'id réel
            $group->code = 'GRP-' . str_pad($group->id, 3, '0', STR_PAD_LEFT);
            $group->save();

            DB::commit();

            return redirect()->route('admin.groups.index')
                             ->with('success', 'Groupe créé avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // log($e) si tu veux : Log::error($e);
            return back()->withInput()->withErrors('Erreur lors de la création du groupe.');
        }
    }


    public function edit(Group $group)
    {
        $exams = Exam::all();
        return view('admin.groups.edit', compact('group', 'exams'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'name'    => 'required|string|max:255',
            'order'   => 'nullable|integer',
        ]);

        $group->update($request->only(['exam_id', 'name', 'order']));

        return redirect()->route('admin.groups.index')
            ->with('success', 'Groupe mis à jour avec succès.');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'Groupe supprimé avec succès.');
    }
}
