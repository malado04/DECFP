@extends('adminlte::page')

@section('title', 'Utilisateurs')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header">
    <h3 class="m-0 text-success d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i> Utilisateurs</span>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-1"></i> Ajouter
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-top-success shadow">
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="usersTable">
            <thead class="bg-success text-white">
                <tr>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Centre</th>
                    <th>Status</th>
                    <th class="text-center"><i class="fas fa-edit"></i></th>
                    <th class="text-center"><i class="fas fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-truncate" title="{{ $user->name }}">{{ $user->name }}</td>
                    <td class="text-truncate" title="{{ $user->email }}">{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-role">{{ $user->role }}</span>
                    </td>
                    <td>{{ $user->centre->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $user->status === 'active' ? 'badge-status-active' : 'badge-status-inactive' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm action-btn">
                            <i class="fas fa-edit me-1"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm action-btn">
                                <i class="fas fa-trash-alt me-1"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links() }}
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
    $('#usersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [
            { orderable: false, targets: [5,6] },
            { className: "text-center", targets: [5,6] }
        ],
        responsive: true
    });
});
</script>
@stop
