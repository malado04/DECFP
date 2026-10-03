@extends('layouts.app')

@section('content')
<h1>Créer un utilisateur</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
    </div>
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label>Confirmer mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="mb-3">
        <label>Centre</label>
        <select name="centre_id" class="form-control">
            <option value="">-- Aucun --</option>
            @foreach($centres as $centre)
                <option value="{{ $centre->id }}">{{ $centre->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Rôle</label>
        <select name="role" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Actif</option>
            <option value="inactive">Inactif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>
@endsection
