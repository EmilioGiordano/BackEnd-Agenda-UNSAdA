<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_plan_asignatura') }}
            {{ Form::text('id_plan_asignatura', $prerequisite->id_plan_asignatura, ['class' => 'form-control' . ($errors->has('id_plan_asignatura') ? ' is-invalid' : ''), 'placeholder' => 'Id Plan Asignatura']) }}
            {!! $errors->first('id_plan_asignatura', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_asignaturaCorrelativa') }}
            {{ Form::text('id_asignaturaCorrelativa', $prerequisite->id_asignaturaCorrelativa, ['class' => 'form-control' . ($errors->has('id_asignaturaCorrelativa') ? ' is-invalid' : ''), 'placeholder' => 'Id Asigcorrelativa']) }}
            {!! $errors->first('id_asignaturaCorrelativa', '<div class="invalid-feedback">:message</div>') !!}
        </div>
     

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>