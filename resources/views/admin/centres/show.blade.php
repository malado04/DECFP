@extends('adminlte::page')

@section('title', 'Détails du centre')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
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

{{-- === Liste des candidats du centre === --}}
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="m-0 text-success">
            <i class="fas fa-users me-2"></i> Liste des examens
        </h3>
    </div>

    <div class="card-body bg-light">
       
        <table class="table table-bordered table-striped" id="examsTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Nom de l’examen</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $exam->code }}</td>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->description ?? '—' }}</td>
                    <td class="d-flex gap-1">
                        {{-- Bouton Voir --}}
                        @if(auth()->user()->hasRole('super-admin'))
                            <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i> 
                            </a>
                        @elseif(auth()->user()->hasRole('centre-admin'))
                            <a href="{{ route('centre.exams.show', $exam) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i> 
                            </a>
                        @elseif(auth()->user()->hasRole('jury'))
                            <a href="{{ route('jury.exam-sessions.show', $exam->session ?? $exam) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i> 
                            </a>
                        @endif

                        {{-- Bouton Modifier --}}
                        @can('update', $exam)
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </a>
                        @endcan

                        {{-- Bouton Supprimer --}}
                        @can('delete', $exam)
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirmer la suppression de cet examen ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
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
    const table = $('#examsTable').DataTable({
    });
});
</script>
@stop
