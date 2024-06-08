@extends('layouts.app')

@section('template_title')
    {{ $planCourse->name ?? "{{ __('Show') Plan Course" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Plan Course</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('plan-courses.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Plan:</strong>
                            {{ $planCourse->id_plan }}
                        </div>
                        <div class="form-group">
                            <strong>Id Asignatura:</strong>
                            {{ $planCourse->id_asignatura }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
