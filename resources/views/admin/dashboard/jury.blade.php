@extends('adminlte::page')

@section('title', 'Dashboard Jury')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-primary card-header bg-light">
    <h1 class="m-0 text-primary">
        <i class="fas fa-user-check me-2"></i> Tableau de bord Jury : {{ auth()->user()->name }}
    </h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-left-primary shadow-sm">
            <div class="card-body">
                <h5>Candidats à corriger</h5>
                <h2>{{ $totalCandidates }}</h2>
                <i class="fas fa-user-graduate fa-2x float-end text-primary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-left-success shadow-sm">
            <div class="card-body">
                <h5>Sessions attribuées</h5>
                <h2>{{ $totalSessions }}</h2>
                <i class="fas fa-calendar fa-2x float-end text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-left-warning shadow-sm">
            <div class="card-body">
                <h5>Scores validés</h5>
                <h2>{{ $validatedScores }}</h2>
                <i class="fas fa-check fa-2x float-end text-warning"></i>
            </div>
        </div>
    </div>
</div>

{{-- Graphique : Statut des scores --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-header bg-light"><h5>Répartition des candidats par session</h5></div>
            <div class="card-body">
                <canvas id="sessionsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-start border-warning border-4">
            <div class="card-header bg-light"><h5>Statut des scores</h5></div>
            <div class="card-body">
                <canvas id="scoresStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('sessionsChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: @json($sessionsLabels),
        datasets: [{
            label: 'Candidats à corriger',
            data: @json($sessionsCounts),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: { responsive: true }
});

const ctx2 = document.getElementById('scoresStatusChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Validés', 'Non validés'],
        datasets: [{
            data: [
                {{ $validatedScores }},
                {{ $totalCandidates - $validatedScores }}
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.6)',
                'rgba(220, 53, 69, 0.6)'
            ],
            borderWidth: 1
        }]
    },
    options: { responsive: true }
});
</script>
@stop
