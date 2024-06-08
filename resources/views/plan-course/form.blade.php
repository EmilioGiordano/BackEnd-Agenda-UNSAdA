<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            {{ Form::label('id_plan', 'Plan') }}
            {{ Form::select('id_plan', $carrerPlans, null, ['class' => 'form-control' . ($errors->has('id_plan') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una opción']) }}
            {!! $errors->first('id_plan', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_asignatura', 'Asignatura') }}
            {{ Form::select('id_asignatura', $courses, null, ['class' => 'form-control' . ($errors->has('id_asignatura') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una opción']) }}
            {!! $errors->first('id_asignatura', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>