@extends('layouts.app')

@section('content')
<h1>Détails de l'utilisateur</h1>

<ul class="list-group">
    <li class="list-group-item"><strong>Nom complet:</strong> {{ $user->full_name }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
    <li class="list-group-item"><strong>Centre:</strong> {{ $user->centre?->name ?? '-' }}</li>
    <li class="list-group-item"><strong>Rôle(s):</strong> {{ $user->getRoleNames()->implode(', ') }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ $user->status }}</li>
    <li class="list-group-item"><strong>Téléphone:</strong> {{ $user->phone ?? '-' }}</li>
    <li class="list-group-item"><strong>Photo:</strong>
        @if($user->profile_photo_path)
            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" width="100" alt="Photo">
        @endif
    </li>
</ul>

<a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
@endsection
