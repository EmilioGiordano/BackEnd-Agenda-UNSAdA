@extends('layouts.app')

@section('template_title')
    {{ $prerequisite->name ?? "{{ __('Show') Prerequisite" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Prerequisite</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('prerequisites.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Asigcorrelativa:</strong>
                            {{ $prerequisite->id_asigCorrelativa }}
                        </div>
                        <div class="form-group">
                            <strong>Id Plan Asignatura:</strong>
                            {{ $prerequisite->id_plan_asignatura }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
