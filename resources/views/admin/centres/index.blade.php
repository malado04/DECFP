@extends('adminlte::page')

@section('title', 'Centres')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-school me-2"></i> Centres d’examen
        <a href="{{ route('admin.centres.create') }}" class="btn btn-success float-end" style="float:right;">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>

    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <table class="table table-bordered table-striped" id="centresTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Région</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Voir</th>
                    <th>Éditer</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($centres as $centre)
                <tr>
                    <td>{{ $centre->code }}</td>
                    <td>{{ $centre->name }}</td>
                    <td>{{ $centre->region }}</td>
                    <td>{{ $centre->contact_email ?? '-' }}</td>
                    <td>{{ $centre->contact_phone ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.centres.show', $centre) }}" class="btn btn-info btn-sm action-btn">
                            <i class="fas fa-eye me-1"></i> Voir
                        </a>
                    </td>
                        <a href="{{ route('admin.centres.sessions', $centre) }}"
                           class="btn btn-sm btn-primary">
                           <i class="fas fa-calendar"></i> Sessions
                        </a>
                    <td>
                        <a href="{{ route('admin.centres.edit', $centre) }}" class="btn btn-warning btn-sm action-btn">
                            <i class="fas fa-edit me-1"></i> Éditer
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.centres.destroy', $centre) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce centre ?');">
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
            <!-- {.{ $centres->links() }} -->
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
    $('#centresTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [
            { orderable: false, targets: [5,6,7] } // Actions non triables
        ],
        responsive: true
    });
});
</script>
@stop
