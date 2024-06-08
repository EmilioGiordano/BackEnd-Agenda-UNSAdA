@extends('layouts.app')

@section('template_title')
    Prerequisite
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Prerequisite') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('prerequisites.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>ID</th>

                                        <th>Plan de carrera</th>
										<th>Asignatura contenida </th>
                                        <th>Correlativa</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prerequisites as $prerequisite)
                                        <tr>
                                            <td>{{ $prerequisite->id }}</td>
                                            <!-- Plan de carrera -->
                                            <td>{{ $prerequisite->PlanCourse->carrerPlan->name }}</td>
                                            <!-- Asignatura contenida -->
                                            <td>{{ $prerequisite->PlanCourse->course->name}}</td>
                                            <!-- Asignatura corrrelativa -->
                                             <!-- Asignatura corrrelativa -->
                                            <td>{{ $prerequisite->course ? $prerequisite->course->name : 'N/A' }}</td> 
                                            <td>
                                                <form action="{{ route('prerequisites.destroy',$prerequisite->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('prerequisites.show',$prerequisite->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('prerequisites.edit',$prerequisite->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $prerequisites->links() !!}
            </div>
        </div>
    </div>
@endsection
