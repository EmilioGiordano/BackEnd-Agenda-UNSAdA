@extends('layouts.app')

@section('template_title')
    Plan Course
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Plan Course') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('plan-courses.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>ID relación</th>
                                        <th>ID PLAN</th>
										<th>Plan de carrera</th>
										<th>ID Asignatura</th>
                                        <th>Asignatura</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planCourses as $planCourse)
                                        <tr>
                                            <td>{{ $planCourse->id }}</td>
                                            <td>{{ $planCourse->id_plan }}</td>
											<td>{{ $planCourse->carrerPlan->name}}</td>
                                            <td>{{ $planCourse->id_asignatura}}</td>
											<td>{{ $planCourse->course->name}}</td>
                                            <td>
                                                <form action="{{ route('plan-courses.destroy',$planCourse->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('plan-courses.show',$planCourse->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('plan-courses.edit',$planCourse->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $planCourses->links() !!}
            </div>
        </div>
    </div>
@endsection
