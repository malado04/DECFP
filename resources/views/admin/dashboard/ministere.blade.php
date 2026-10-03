@extends('adminlte::page')

@section('title', 'Dashboard Ministère')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-chart-pie me-2"></i> Tableau de bord Ministère
    </h3>
</div>
@stop

@section('content')

{{-- Filtre par session --}}
<div class="row mb-3">
    <div class="col-md-4">
        <form method="GET" action="{{ route('admin.dashboard.ministere') }}">
            <select name="session_id" class="form-select form-control" onchange="this.form.submit()">
                <option value="">-- Sélectionner une session --</option>
                @foreach($allSessions as $session)
                    <option value="{{ $session->id }}" 
                        {{ isset($selectedSession) && $selectedSession->id == $session->id ? 'selected' : '' }}>
                        {{ $session->exam->title ?? '[Examen]' }} - {{ $session->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

{{-- Statistiques globales --}}
<div class="row">

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
        <div class="card card-left-success shadow-sm">
            <div class="card-body">
                <h5>Total Centres</h5>
                <h2>{{ $totalCentres }}</h2>
                <i class="fas fa-school fa-2x float-end text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-left-warning shadow-sm">
            <div class="card-body">
                <h5>Total Jurys</h5>
                <h2>{{ $totalJurys }}</h2>
                <i class="fas fa-users fa-2x float-end text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-left-danger shadow-sm">
            <div class="card-body">
                <h5>Total Candidats</h5>
                <h2>{{ $totalCandidates }}</h2>
                <i class="fas fa-user-graduate fa-2x float-end text-danger"></i>
            </div>
        </div>
    </div>

</div>

{{-- Graphique des sessions --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-header">
                <h5>Répartition des candidats par session</h5>
            </div>
            <div class="card-body">
                <canvas id="sessionsChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Top 5 centres --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-header bg-light">
                <h5>Top 5 Centres par nombre de candidats</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($topCentres as $centre)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $centre->name }}
                            <span class="badge bg-success rounded-pill">{{ $centre->candidates_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- 10 derniers candidats --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-warning border-4">
            <div class="card-header bg-light">
                <h5>10 derniers candidats inscrits</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($recentCandidates as $candidate)
                        <li class="list-group-item">
                            {{ $candidate->full_name }} 
                            <small class="text-muted">({{ $candidate->centre->name ?? 'N/A' }})</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('sessionsChart').getContext('2d');
const sessionsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($sessionsLabels),
        datasets: [{
            label: 'Nombre de candidats',
            data: @json($sessionsCounts),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Candidats' } },
            x: { title: { display: true, text: 'Sessions' } }
        }
    }
});
</script>
@stop
