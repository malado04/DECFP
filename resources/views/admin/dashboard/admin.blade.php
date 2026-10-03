@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-primary card-header bg-light">
    <h1 class="m-0 text-primary">
        <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord Admin
    </h1>
</div>
@stop
@section('content')

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


{{-- Analyse CCP --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-info border-4">
            <div class="card-header bg-light">
                <h5><i class="fas fa-balance-scale me-2 text-info"></i> Analyse par Compétence (CCP)</h5>
            </div>
            <div class="card-body">

                <table class="table table-sm table-striped">
                    <thead class="table-info">
                        <tr>
                            <th>CCP</th>
                            <th>Pondération</th>
                            <th>Moyenne</th>
                            <th>Difficulté</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ccpAnalysis as $ccp)
                        <tr>
                            <td>{{ $ccp->competency->title }}</td>
                            <td><strong>{{ $ccp->weight }}</strong></td>
                            <td>{{ number_format($ccp->average_score, 2) }}</td>

                            <td>
                                @if($ccp->difficulte === 'Faible')
                                    <span class="badge bg-success">Facile</span>
                                @elseif($ccp->difficulte === 'Moyenne')
                                    <span class="badge bg-warning">Moyenne</span>
                                @else
                                    <span class="badge bg-danger">Difficile</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- Graphique radar --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-header bg-light">
                <h5><i class="fas fa-chart-pie me-2 text-primary"></i> Diagramme de Performance CCP</h5>
            </div>
            <div class="card-body">
                <canvas id="ccpRadarChart"></canvas>
            </div>
        </div>
    </div>
</div>


{{-- Répartition par session --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-header">
                <h5>Répartition des candidats par session</h5>
            </div>
            <div class="card-body">
                <canvas id="sessionsChart"></canvas>
            </div>
        </div>
    </div>
</div>


{{-- Top centres + derniers candidats --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-header bg-light"><h5>Top 5 centres</h5></div>
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

    <div class="col-md-6">
        <div class="card shadow-sm border-start border-warning border-4">
            <div class="card-header bg-light"><h5>10 derniers candidats</h5></div>
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

{{-- Bar Chart --}}
<script>
const ctx = document.getElementById('sessionsChart').getContext('2d');
new Chart(ctx, {
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
    options: { scales: { y: { beginAtZero: true } } }
});
</script>

{{-- Radar Chart CCP --}}
<script>
const ctxRadar = document.getElementById('ccpRadarChart').getContext('2d');
new Chart(ctxRadar, {
    type: 'radar',
    data: {
        labels: @json($ccpLabels),
        datasets: [
            {
                label: 'Moyenne par CCP',
                data: @json($ccpAverages),
                backgroundColor: "rgba(54, 162, 235, 0.3)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 2
            },
            {
                label: 'Pondération',
                data: @json($ccpWeights),
                backgroundColor: "rgba(255, 159, 64, 0.3)",
                borderColor: "rgba(255, 159, 64, 1)",
                borderWidth: 2
            }
        ]
    }
});
</script>

@stop
