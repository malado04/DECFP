@extends('layouts.app')

@section('content')
<h1>Éditer utilisateur</h1>

<form action="{{ route('users.update',$user) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name',$user->first_name) }}">
    </div>
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name',$user->last_name) }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}">
    </div>
    <div class="mb-3">
        <label>Mot de passe (laisser vide pour conserver)</label>
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
                <option value="{{ $centre->id }}" {{ $user->centre_id==$centre->id ? 'selected':'' }}>{{ $centre->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Rôle</label>
        <select name="role" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $user->hasRole($role->name)?'selected':'' }}>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ $user->status=='active'?'selected':'' }}>Actif</option>
            <option value="inactive" {{ $user->status=='inactive'?'selected':'' }}>Inactif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>
@endsection
