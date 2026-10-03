@extends('adminlte::page')

@section('title', 'Détail Session d\'examen')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop


@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success p-2">
        <i class="fas fa-calendar-alt me-2"></i> Détail de la session : {{ $exam_session->name }}

        <a href="{{ route('admin.exams.show',  $exam_session->exam_id) }}" class="btn btn-outline-danger float-end" style="float:right;">
            <i class="fas fa-plus-circle me-1"></i> Retour
        </a><a href="{{ route('admin.results.index', $session->id) }}" 
   class="btn btn-success" style="float:right; margin-right: 2%;">
    <i class="fas fa-chart-line me-1"></i> Voir les résultats
</a>

<a href="{{ route('admin.results.index', $session->id) }}" 
   class="btn btn-success">
    <i class="fas fa-chart-line me-1"></i> Voir les résultats
</a>

<a href="{{ route('admin.results.index', [$session->id, $session2 ?? null]) }}" 
   class="btn btn-success">
    <i class="fas fa-chart-line me-1"></i> Voir les résultats 1 et 2
</a>

    </h3>
</div>
@stop
@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">

        {{-- Informations générales --}}
        <h4>Informations sur la session</h4>
        <table class="table table-bordered mb-4">
            <tbody>
                <tr>
                    <th>Année académique</th>
                    <td>{{ $exam_session->academic_year }}</td>
                    <th>Centre</th>
                    <td>{{ $exam_session->centre->name ?? '-' }}</td>
                    <th>Date de début</th>
                    <td>{{ $exam_session->start_date->format('d/m/Y') }}</td>
                    <th>Date de fin</th>
                    <td>{{ $exam_session->end_date->format('d/m/Y') }}</td>
                    <th>Type</th>
                    <td>{{ ucfirst($exam_session->type) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">

        {{-- Onglets : Candidats, Scores, Documents --}}
        <ul class="nav nav-tabs mb-3" id="sessionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="candidates-tab" data-bs-toggle="tab" data-bs-target="#candidates" type="button" role="tab">Candidats</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="scores-tab" data-bs-toggle="tab" data-bs-target="#scores" type="button" role="tab">Scores</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Documents</button>
            </li>
        </ul>

        <div class="tab-content" id="sessionTabsContent">

            {{-- Candidats --}}
            <div class="tab-pane fade show active" id="candidates" role="tabpanel">
                @if($exam_session->candidates->isEmpty())
                    <p class="text-muted">Aucun candidat inscrit pour cette session.</p>
                @else
                    <table class="table table-bordered table-striped" id="candidatesTable">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>Matr.</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exam_session->candidates as $candidate)
                            <tr>
                                <td>{{ $candidate->registration_number ?? '-' }}</td>
                                <td>{{ $candidate->full_name }}</td>
                                <td>{{ $candidate->email ?? '-' }}</td>
                                <td>{{ ucfirst($candidate->status ?? 'inactif') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Scores --}}
            <div class="tab-pane fade" id="scores" role="tabpanel">
           <a href="{{ route('admin.sessions.scores', ['exam_session' => $exam_session->id]) }}" class="btn btn-success">
                <i class="fas fa-pen"></i> Saisir les scores
            </a><br><br>




                @if($exam_session->scores->isEmpty())
                    <p class="text-muted">Aucun score enregistré pour cette session.</p>
                @else
                    <table class="table table-bordered table-striped" id="scoresTable">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>Candidat</th>
                                <th>Examen</th>
                                <th>Score</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exam_session->scores as $score)
                            <tr>
                                <td>{{ $score->candidate->full_name }}</td>
                                <td>{{ $score->competency->title ?? '-' }}</td>
                                <td>{{ $score->score }}</td>
                                <td>
                                    <a href="{{ route('admin.scores.edit', $score) }}" class="btn btn-sm btn-warning">      Éditer
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Documents --}}
            <div class="tab-pane fade" id="documents" role="tabpanel">
                @if($exam_session->documents->isEmpty())
                    <p class="text-muted">Aucun document soumis pour cette session.</p>
                @else
                    <table class="table table-bordered table-striped" id="documentsTable">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>Candidat</th>
                                <th>Nom du document</th>
                                <th>Type</th>
                                <th>Télécharger</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exam_session->documents as $doc)
                            <tr>
                                <td>{{ $doc->candidate->full_name }}</td>
                                <td>{{ $doc->filename }}</td>
                                <td>{{ $doc->type }}</td>
                                <td><a href="{{ asset('storage/'.$doc->path) }}" class="btn btn-sm btn-success" target="_blank">Télécharger</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>

    </div>
</div>
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#candidatesTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5,10,25,50]
    });
    $('#scoresTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5,10,25,50]
    });
    $('#documentsTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5,10,25,50]
    });
});
</script>
@stop
