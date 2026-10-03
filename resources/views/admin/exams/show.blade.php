@extends('adminlte::page')

@section('title', 'Détail de l’examen')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('content_header')
<div class="card card-left-success shadow border-start border-success border-4 mt-4">
    <div class="card-header">
        <h3 class="m-0 text-success">
            <i class="fas fa-file-alt me-2"></i> Détail de l’examen
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-danger float-end">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
        </h3>
    </div>
    <div class="card-body bg-light">
        <table class="table table-bordered mb-0">
            <tr>
                <th>Code</th>
                <td>{{ $exam->code }}</td>
                <th>Nom</th>
                <td>{{ $exam->title }}</td>
                <th>Description</th>
                <td>{{ $exam->description ?? '—' }}</td>
                <th>Centre</th>
                <td>{{ $exam->centre->name ?? '—' }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Voulez-vous supprimer cet examen ?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{--  LISTE DES SESSIONS D'EXAMEN --}}
{{-- ===================================================== --}}
<div class="card card-left-success shadow border-start border-success border-4 mt-4">
    <div class="card-header bg-light">
        <h4 class="text-success mb-0">
            <i class="fas fa-calendar-alt me-2"></i> Sessions d'examen
        </h4>
    </div>
    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="sessionsTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>#</th>
                    <th>Nom session</th>
                    <th>Année</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <!-- <th>Statut</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->academic_year }}</td>
                    <td>{{ $session->start_date }}</td>
                    <td>{{ $session->end_date }}</td>
                 <!--    <td>
                        <span class="badge bg-{{ $session->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </td> -->
                    <td>
                        <a href="{{ route('admin.exam_sessions.showM', $session) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <!-- <a href="{.{ route('admin.exam_sessions.edit', $session) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ===================================================== --}}
{{-- COMPÉTENCES ASSOCIÉES --}}
{{-- ===================================================== --}}
<div class="card card-left-success shadow border-start border-success border-4 mt-4">
    <div class="card-header bg-light">
        <h4 class="text-success mb-0">
            <i class="fas fa-tasks me-2"></i> Pondération des compétences
        </h4>
    </div>
    <div class="card-body bg-light">
    @if($competencies->count() == 0)
        <p class="text-muted">Aucune compétence enregistrée pour cet examen.</p>
    @else
    <form action="{{ route('admin.weights.updateAll', [$exam]) }}" method="POST">
    @csrf
    @method('PATCH')
        <table class="table table-bordered table-striped" id="competenciesTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Max Score</th>
                    <th>Poids / Coef</th>
                </tr>
            </thead>

            <tbody>
            @foreach($competencies as $competency)
                <tr>
                    <td>{{ $competency->code }}</td>
                    <td>{{ $competency->title }}</td>
                    <td>{{ $competency->max_score }}</td>

                    <td>

                        <input type="number"
                            name="weights[{{ $competency->id }}]"
                            step="0.1"
                            value="{{ $competency->ccpWeight->weight ?? 1 }}"
                            class="border rounded p-1 w-20 form-controller">
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">
                        <button class="btn btn-success text-white px-4" style="float:right;">Enregistrer</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    @endif
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
        $('#sessionsTable').DataTable();
        $('#competenciesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        columnDefs: [
            { orderable: true, targets: [0,1] }
        ]
    });
});
</script>
@stop
