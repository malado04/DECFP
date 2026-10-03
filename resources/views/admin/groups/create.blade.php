@extends('adminlte::page')

@section('title', 'Créer Groupe')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        Créer un Groupe
        <a href="{{ route('admin.groups.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <form action="{{ route('admin.groups.store') }}" method="POST">
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

    </div>
</div>
@stop
