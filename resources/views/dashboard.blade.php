@extends('adminlte::page')

@section('title', 'Tableau de bord')

@section('content_header')
    <h1 class="mb-4">📊 Tableau de bord</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Statistiques globales -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalCandidates ?? 0 }}</h3>
                    <p>Candidats inscrits</p>
                </div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSessions ?? 0 }}</h3>
                    <p>Sessions d'examen</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalCentres ?? 0 }}</h3>
                    <p>Centres d’examen</p>
                </div>
                <div class="icon"><i class="fas fa-school"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalJurys ?? 0 }}</h3>
                    <p>Membres du jury</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">📈 Répartition des candidats par session</h5>
                </div>
                <div class="card-body">
                    <canvas id="candidatesChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">🏫 Centres les plus actifs</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($topCentres ?? [] as $centre)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $centre->nom }}
                                <span class="badge bg-primary">{{ $centre->candidats_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des dernières inscriptions -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">🕓 Dernières inscriptions</h5>
        </div>
        <div class="card-body">
            <table id="candidatesTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom & Prénom</th>
                        <th>Session</th>
                        <th>Centre</th>
                        <th>Date inscription</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentCandidates ?? [] as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $c->nom }} {{ $c->prenom }}</td>
                        <td>{{ $c->session->nom ?? '—' }}</td>
                        <td>{{ $c->centre->nom ?? '—' }}</td>
                        <td>{{ $c->created_at?->format('d/m/Y') }}</td>
                        <td>
                            @if($c->status === 'valide')
                                <span class="badge bg-success">Validé</span>
                            @else
                                <span class="badge bg-secondary">En attente</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#candidatesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50]
            });
        });

        // Graphique des candidats
        const ctx = document.getElementById('candidatesChart').getContext('2d');
        const candidatesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($sessionsLabels ?? []) !!},
                datasets: [{
                    label: 'Nombre de candidats',
                    data: {!! json_encode($sessionsCounts ?? []) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@stop
