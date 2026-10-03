@extends('adminlte::page')

@section('title', 'Espace Étudiant')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-success card-header bg-light">
    <h1 class="m-0 text-success">
        <i class="fas fa-user-graduate me-2"></i> Tableau de bord Étudiant : {{ auth()->user()->name }}
    </h1>
</div>
@stop

@section('content')
{{-- KPI --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-left-primary shadow-sm border-start border-primary border-4">
            <div class="card-body">
                <h6 class="text-muted">Sessions suivies</h6>
                <h2 class="fw-bold">{{ $totalSessions }}</h2>
                <i class="fas fa-calendar text-primary float-end"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-left-success shadow-sm border-start border-success border-4">
            <div class="card-body">
                <h6 class="text-muted">Examens réussis</h6>
                <h2 class="fw-bold text-success">{{ $admis }}</h2>
                <i class="fas fa-check-circle text-success float-end"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-left-danger shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <h6 class="text-muted">À reprendre</h6>
                <h2 class="fw-bold text-danger">{{ $ajourne }}</h2>
                <i class="fas fa-times-circle text-danger float-end"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-left-warning shadow-sm border-start border-warning border-4">
            <div class="card-body">
                <h6 class="text-muted">Moyenne générale</h6>
                <h2 class="fw-bold text-warning">{{ number_format($sessionsAverages->avg(), 2) ?? '—' }}</h2>
                <i class="fas fa-chart-line text-warning float-end"></i>
            </div>
        </div>
    </div>
</div>

{{-- Graphique Moyenne par session --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-chart-bar me-2"></i> Moyenne par session
            </div>
            <div class="card-body">
                <canvas id="averageChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Tableau récapitulatif des résultats --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-list me-2"></i> Détail des résultats
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Session</th>
                            <th>Examen</th>
                            <th>Moyenne</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->examSession->name ?? '-' }}</td>
                                <td>{{ $candidate->exam->name ?? '-' }}</td>
                                <td class="fw-bold">{{ $candidate->calculateFinalAverage($candidate->exam_session_id) ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $candidate->status === 'admis' ? 'bg-success' : 'bg-danger' }}">
                                        {{ strtoupper($candidate->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('averageChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($sessionsLabels),
        datasets: [{
            label: 'Moyenne',
            data: @json($sessionsAverages),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, max: 20, title: { display: true, text: 'Moyenne' } },
            x: { title: { display: true, text: 'Sessions' } }
        }
    }
});
</script>
@stop
