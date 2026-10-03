@extends('layouts.app')

@section('content')
<h1>Liste des utilisateurs</h1>

<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Créer un utilisateur</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom complet</th>
            <th>Email</th>
            <th>Centre</th>
            <th>Rôle</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->centre?->name ?? '-' }}</td>
            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
            <td>{{ $user->status }}</td>
            <td>
                <a href="{{ route('users.show',$user) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('users.edit',$user) }}" class="btn btn-warning btn-sm">Éditer</a>
                <form action="{{ route('users.destroy',$user) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
