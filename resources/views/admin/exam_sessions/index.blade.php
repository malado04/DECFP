@extends('adminlte::page')

@section('title', 'Sessions d’examen')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-calendar-alt me-2"></i> Sessions d’examen
        <a href="{{ route('admin.exam_sessions.create') }}" class="btn btn-success float-end" style="float:right;">
            <i class="fas fa-plus-circle me-1"></i> Nouvelle session
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">

        <table id="sessionsTable" class="table table-bordered table-striped">
            <thead class="bg-success text-white">
                <tr>
                    <th>Nom</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Centre</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sessions as $session)
                <tr>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->start_date }}</td>
                    <td>{{ $session->end_date }}</td>

                    {{-- 🔹 IMPORTANT : relation correcte centre (belongsTo Centre) --}}
                    <td>{{ $session->centre->name ?? '-' }}</td>

                    <td class="text-center">

                        <a href="{{ route('admin.exam_sessions.show', $session->id) }}"
                            class="btn btn-info btn-sm action-btn">
                            <i class="fas fa-eye me-1"></i> Voir
                        </a>

                        <a href="{{ route('admin.exam_sessions.edit', $session->id) }}"
                            class="btn btn-warning btn-sm action-btn">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>

                        <form action="{{ route('admin.exam_sessions.destroy', $session->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer cette session ?');">
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

    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#sessionsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        pageLength: 10,
        lengthMenu: [5,10,25,50],
        columnDefs: [
            { orderable: false, targets: 4 } // Actions non triables
        ]
    });
});
</script>
@stop
