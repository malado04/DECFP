@extends('adminlte::page')

@section('title', 'Compétences')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-list-check me-2"></i> Compétences
        <a href="{{ route('admin.competencies.create') }}" class="btn btn-success float-end">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="competenciesTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Examen</th>
                    <th>Coefficient</th>
                    <th>Groupe</th>
                    <th>Ordre</th>
                    <th><i class="fas fa-eye me-1"></i></th>
                    <th><i class="fas fa-edit me-1"></i></th>
                    <th><i class="fas fa-trash-alt me-1"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($competencies as $competency)
                <tr>
                    <td>{{ $competency->code }}</td>
                    <td>{{ $competency->title }}</td>
                    <td>{{ $competency->exam->title ?? '-' }}</td>
                    <td>{{ $competency->coefficient }}</td>
                    <td>{{ $competency->group->name?? '-' }}</td>
                    <td>{{ $competency->order }}</td>
                    <td>
                        <a href="{{ route('admin.competencies.show', $competency) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-eye me-1"></i> Voir
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.competencies.edit', $competency) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i> Éditer
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.competencies.destroy', $competency) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette compétence ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt me-1"></i> Supprimer
                            </button>
                        </form>
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
    $('#competenciesTable').DataTable({
    });
});
</script>
@stop
