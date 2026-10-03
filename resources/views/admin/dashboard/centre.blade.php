@extends('adminlte::page')

@section('title', 'Dashboard Centre')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<h1 class="text-primary">
    <i class="fas fa-school me-2"></i> Tableau de bord du Centre : {{ $centre->name }}
</h1>
@stop

@section('content')
<div class="row">
    {{-- Statistiques globales --}}
    <div class="col-md-3">
        <div class="card card-left-success shadow-sm">
            <div class="card-body">
                <h5>Total Candidats</h5>
                <h2>{{ $totalCandidates }}</h2>
                <i class="fas fa-user-graduate fa-2x float-end text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-left-primary shadow-sm">
            <div class="card-body">
                <h5>Total Sessions</h5>
                <h2>{{ $totalSessions }}</h2>
                <i class="fas fa-calendar fa-2x float-end text-primary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-left-warning shadow-sm">
            <div class="card-body">
                <h5>Jurys Affectés</h5>
                <h2>{{ $totalJurys }}</h2>
                <i class="fas fa-users fa-2x float-end text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-left-danger shadow-sm">
            <div class="card-body">
                <h5>Scores Non Validés</h5>
                <h2>{{ $pendingScores }}</h2>
                <i class="fas fa-exclamation-circle fa-2x float-end text-danger"></i>
            </div>
        </div>
    </div>
</div>

@stop
