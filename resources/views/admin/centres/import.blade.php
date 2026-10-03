@extends('adminlte::page')

@section('title', 'Importer des candidats')

@section('content_header')
    <h1>Importer des candidats pour le centre : {{ $centre->name }}</h1>
@stop

@section('content')
    <form action="{{ route('admin.centres.import', $centre->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Fichier Excel / CSV</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Importer</button>
        <a href="{{ route('admin.centres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@stop
