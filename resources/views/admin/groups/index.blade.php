@extends('adminlte::page')

@section('title', 'Examens')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-file-alt me-2"></i> Groupes
        <a href="{{ route('admin.groups.create') }}" class="btn btn-success float-end">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">

<table class="table table-bordered table-striped" id="examsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Nom</th>
            <th>Examen</th>
            <th>Ordre</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($groups as $group)
        <tr>
            <td>{{ $group->id }}</td>
            <td>{{ $group->code }}</td>
            <td>{{ $group->name }}</td>
            <td>{{ $group->exam->title }}</td>
            <td>{{ $group->order }}</td>
            <td>
                <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-warning btn-sm">Modifier</a>

                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#examsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });
});
</script>
@stop
