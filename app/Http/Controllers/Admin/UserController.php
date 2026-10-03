<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Centre;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        $users = User::with('roles', 'centre')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $roles = Role::all();
        $centres = Centre::all();
        return view('admin.users.create', compact('roles','centres'));
    }

    /**
     * Enregistrement d'un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            'centre_id'=>'nullable|exists:centres,id',
            'role'=>'required|string|exists:roles,name',
            'phone'=>'nullable|string|max:20',
            'status'=>'required|in:active,inactive',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()->route('admin.users.index')->with('success','Utilisateur créé avec succès.');
    }

    /**
     * Affichage d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $centres = Centre::all();
        return view('admin.users.edit', compact('user','roles','centres'));
    }

    /**
     * Mise à jour d'un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>"required|email|unique:users,email,{$user->id}",
            'password'=>'nullable|string|min:6|confirmed',
            'centre_id'=>'nullable|exists:centres,id',
            'role'=>'required|string|exists:roles,name',
            'phone'=>'nullable|string|max:20',
            'status'=>'required|in:active,inactive',
        ]);

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index')->with('success','Utilisateur mis à jour avec succès.');
    }

    /**
     * Suppression d'un utilisateur
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','Utilisateur supprimé.');
    }
}
