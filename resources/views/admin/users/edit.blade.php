@extends('adminlte::page')

@section('title', 'Éditer Utilisateur')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header">
    <h3 class="m-0 text-success d-flex justify-content-between align-items-center">
        <span><i class="fas fa-user-edit me-2"></i> Éditer Utilisateur</span>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">Prénom</label>
                    <input type="text" name="first_name" id="first_name" 
                           class="form-control @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="form-label">Nom</label>
                    <input type="text" name="last_name" id="last_name" 
                           class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $user->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label">Mot de passe <small>(laisser vide pour conserver)</small></label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirmation mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="role" class="form-label">Rôle</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="centre_id" class="form-label">Centre</label>
                    <select name="centre_id" id="centre_id" class="form-select @error('centre_id') is-invalid @enderror">
                        <option value="">-- Aucun --</option>
                        @foreach($centres as $centre)
                            <option value="{{ $centre->id }}" {{ $user->centre_id == $centre->id ? 'selected' : '' }}>
                                {{ $centre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('centre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Enregistrer les modifications
            </button>
        </form>
    </div>
</div>
@stop
