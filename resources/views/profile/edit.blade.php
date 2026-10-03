@extends('adminlte::page')

@section('title', 'Profil')

@section('css')
<style>
    .card-left-success {
        border-left: 7px solid #28a745;
        border-radius: 0.5rem;
    }
    .card-left-primary {
        border-left: 7px solid #007bff;
        border-radius: 0.5rem;
    }
    .card-left-danger {
        border-left: 7px solid #dc3545;
        border-radius: 0.5rem;
    }
</style>
@stop

@section('content_header')
<div class="card-left-primary card-header bg-light shadow-sm mb-3 d-flex justify-content-between align-items-center">
    <h3 class="m-0 text-primary">
        <i class="fas fa-user me-2"></i> Profil
    </h3>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- Informations personnelles --}}
        <div class="card card-left-success shadow border-start border-primary border-4 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0"><i class="fas fa-id-card me-2"></i> Informations personnelles</h3>
            </div>
            <div class="card-body bg-light">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>
    <div class="col-md-12">

        {{-- Mot de passe --}}
        <div class="card card-left-primary shadow border-start border-primary border-4 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0"><i class="fas fa-key me-2"></i> Modifier le mot de passe</h3>
            </div>
            <div class="card-body bg-light">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
    <div class="col-md-12">
        {{-- Supprimer le compte --}}
        <div class="card card-left-danger shadow border-start border-danger border-4 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0"><i class="fas fa-user-slash me-2"></i> Supprimer le compte</h3>
            </div>
            <div class="card-body bg-light">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@stop
