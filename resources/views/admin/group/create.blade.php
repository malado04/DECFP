@extends('adminlte::page')

@section('title', 'Créer Groupe')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
    <h1 class="text-primary fw-bold">Créer un Groupe</h1>
@stop

@section('content')

<form action="{{ route('groups.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Examen</label>
        <select name="exam_id" class="form-control" required>
            @foreach($exams as $exam)
                <option value="{{ $exam->id }}">{{ $exam->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nom du groupe</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Ordre</label>
        <input type="number" name="order" class="form-control">
    </div>

    <button class="btn btn-success">Enregistrer</button>
</form>

@stop
