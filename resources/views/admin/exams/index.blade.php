@extends('adminlte::page')

@section('title', 'Examens')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-file-alt me-2"></i> Examens
        <a href="{{ route('admin.exams.create') }}" class="btn btn-success float-end">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="examsTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Centre</th>
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
                    <td>{{ $exam->centre->name ?? '-' }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-success btn-sm action-btn">
                            <i class="fas fa-eye me-1"></i> Voir
                        </a>
                        <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-warning btn-sm action-btn">
                            <i class="fas fa-edit me-1"></i> Éditer
                        </a>
                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous supprimer cet examen ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm action-btn">
                                <i class="fas fa-trash-alt me-1"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <!-- {.{ $exams->links() }} -->
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
