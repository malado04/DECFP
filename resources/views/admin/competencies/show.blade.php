@extends('adminlte::page')

@section('title', 'Détail compétence')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-info card-header bg-light">
    <h3 class="m-0 text-info">
        <i class="fas fa-eye me-2"></i> Détail de la compétence
        <a href="{{ route('admin.competencies.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-info shadow border-start border-info border-4">
    <div class="card-body"> 
        <dl class="row">
            <dt class="col-sm-3">Examen</dt>
            <dd class="col-sm-9">{{ $competency->exam->title ?? '-' }}</dd>

            <dt class="col-sm-3">Code</dt>
            <dd class="col-sm-9">{{ $competency->code }}</dd>

            <dt class="col-sm-3">Titre</dt>
            <dd class="col-sm-9">{{ $competency->title }}</dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $competency->description ?? '-' }}</dd>

            <dt class="col-sm-3">Score maximum</dt>
            <dd class="col-sm-9">{{ $competency->max_score }}</dd>

            <dt class="col-sm-3">Créé le</dt>
            <dd class="col-sm-9">{{ $competency->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Mis à jour le</dt>
            <dd class="col-sm-9">{{ $competency->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop
