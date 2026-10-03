@extends('adminlte::page')

@section('title', 'Candidats')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-user-graduate me-2"></i> Candidats
        <a href="{{ route('admin.candidates.create') }}" class="btn btn-success float-end">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="candidatesTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>Numéro</th>
                    <th>Nom complet</th>
                    <th>Centre</th>
                    <th>Examen</th>
                    <th>Session</th>
                    <th>Status</th>
                    <th><i class="fas fa-edit me-1"></i></th>
                    <th><i class="fas fa-trash-alt me-1"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidates as $candidate)
                <tr>
                    <td>{{ $candidate->registration_number }}</td>
                    <td>{{ $candidate->full_name }}</td>
                    <td>{{ $candidate->centre->name ?? '-' }}</td>
                    <td>{{ $candidate->exam->title ?? '-' }}</td>
                    <td>{{ $candidate->examSession->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $candidate->status === 'admis' ? 'badge-success' : ($candidate->status === 'ajourné' ? 'badge-warning' : ($candidate->status === 'absent' ? 'badge-danger' : 'badge-secondary')) }}">
                            {{ ucfirst($candidate->status ?? 'inscrit') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Éditer
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce candidat ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt me-1"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#candidatesTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5,10,25,50],
        columnDefs: [ { orderable: false, targets: [6,7] } ]
    });
});
</script>
@stop
