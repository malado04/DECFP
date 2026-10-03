@extends('adminlte::page')

@section('title', 'Modifier Groupe')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
    <h1 class="text-primary fw-bold">Modifier le Groupe</h1>
@stop

@section('content')

<form action="{{ route('groups.update', $group) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Examen</label>
        <select name="exam_id" class="form-control" required>
            @foreach($exams as $exam)
                <option value="{{ $exam->id }}" 
                    {{ $group->exam_id == $exam->id ? 'selected' : '' }}>
                    {{ $exam->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Nom du groupe</label>
        <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
    </div>

    <div class="mb-3">
        <label>Ordre</label>
        <input type="number" name="order" class="form-control" value="{{ $group->order }}">
    </div>

    <button class="btn btn-success">Mettre à jour</button>
</form>

@stop
