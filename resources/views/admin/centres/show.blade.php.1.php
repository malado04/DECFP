@extends('adminlte::page')

@section('title', 'Détails du centre')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<style>
    .card-left-success {
        border-left: 7px solid #28a745;
        border-radius: 0.5rem;
    }
    .stat-card {
        border-left: 6px solid #28a745;
        border-radius: 0.5rem;
        background: #f8f9fa;
        padding: 10px;
        text-align: center;
    }
    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
    }
</style>
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-school me-2"></i> Détails du centre
        <a href="{{ route('admin.centres.index') }}" class="btn btn-outline-danger float-end" style="float:right;">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </h3>
</div>
@stop

@section('content')
{{-- === Détails du centre === --}}
<div class="card card-left-success shadow border-start border-success border-4 mb-4">
    <!-- <div class="card-body bg-light">
        <table class="table table-bordered table-striped mb-0">
            <tbody>
                <tr>
                    <th><i class="fas fa-barcode me-1 text-success"></i> Code</th>
                    <td>{{ $centre->code }}</td>
                    <th><i class="fas fa-school me-1 text-success"></i> Nom</th>
                    <td>{{ $centre->name }}</td>
                    <th><i class="fas fa-map-marker-alt me-1 text-success"></i> Région</th>
                    <td>{{ $centre->region }}</td>
                </tr>
                <tr>
                    <th><i class="fas fa-envelope me-1 text-success"></i> Email</th>
                    <td>{{ $centre->contact_email ?? '-' }}</td>
                    <th><i class="fas fa-phone me-1 text-success"></i> Téléphone</th>
                    <td>{{ $centre->contact_phone ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div> 

    <div class="card-footer bg-white text-end">
        <a href="{{ route('admin.centres.edit', $centre->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-1"></i> Modifier
        </a>
        <form action="{{ route('admin.centres.destroy', $centre->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Voulez-vous vraiment supprimer ce centre ?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">
                <i class="fas fa-trash-alt me-1"></i> Supprimer
            </button>
        </form>
    </div>-->
</div>

{{-- === Statistiques des candidats === --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-info border-4">
            <div class="stat-number text-info">{{ $centre->candidats->count() }}</div>
            <div>Total inscrits</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-success border-4">
            <div class="stat-number text-success">{{ $centre->candidats->where('status','admis')->count() }}</div>
            <div>Admis</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-warning border-4">
            <div class="stat-number text-warning">{{ $centre->candidats->where('status','ajourné')->count() }}</div>
            <div>Ajournés</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card shadow-sm border-start border-danger border-4">
            <div class="stat-number text-danger">{{ $centre->candidats->where('status','absent')->count() }}</div>
            <div>Absents</div>
        </div>
    </div>
</div>

{{-- === Liste des candidats du centre === --}}
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="m-0 text-success">
            <i class="fas fa-users me-2"></i> Candidats du centre
        </h3>
        <div class="d-flex gap-2">
            <select id="filterExam" class="form-select form-control form-select-sm">
                <option value="">— Filtrer par examen —</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->title }}">{{ $exam->title }}</option>
                @endforeach
            </select>
            <select id="filterSession" class="form-select form-control form-select-sm">
                <option value="">— Filtrer par session —</option>
                @foreach($sessions as $session)
                    <option value="{{ $session->name }}">{{ $session->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.centres.candidates.create', $centre->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Ajouter
            </a>
            <div class="btn-group">
                <a href="{{ route('admin.centres.export', $centre->id) }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-excel"></i> Exporter
                </a>
                <a href="{{ route('admin.centres.import.form', $centre->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-upload"></i> Importer
                </a>
            </div>
        </div>
    </div>

    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="candidatesTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>#</th>
                    <th>Nom complet</th>
                    <th>Numéro dossier</th>
                    <th>Sexe</th>
                    <th>Examen</th>
                    <th>Session</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($centre->candidats ?? [] as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->last_name }} {{ $c->first_name }}</td>
                    <td>{{ $c->registration_number ?? '-' }}</td>
                    <td>{{ $c->sex ?? '-' }}</td>
                    <td>{{ $c->exam->title ?? '-' }}</td>
                    <td>{{ $c->examSession->name ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            @if($c->status=='inscrit') bg-info
                            @elseif($c->status=='admis') bg-success
                            @elseif($c->status=='ajourné') bg-warning
                            @else bg-danger @endif">
                            {{ ucfirst($c->status) }}
                        </span>
                    </td>
                    <td class="d-flex justify-content-center gap-1">
                        <a href="{{ route('admin.centres.candidates.show', [$centre->id, $c->id]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.centres.candidates.edit', ['centre' => $centre->id, 'candidate' => $c->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.centres.candidates.destroy', [$centre, $c]) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce candidat ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun candidat enregistré pour ce centre.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#candidatesTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [ { orderable: false, targets: 7 } ]
    });

    // Filtres dynamiques
    $('#filterExam, #filterSession').on('change', function() {
        const exam = $('#filterExam').val();
        const session = $('#filterSession').val();

        table.column(4).search(exam);
        table.column(5).search(session).draw();
    });
});
</script>
@stop
