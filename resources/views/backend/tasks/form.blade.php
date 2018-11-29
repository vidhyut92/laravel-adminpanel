<?php use Illuminate\Support\Facades\Input; ?>
@extends ('backend.layouts.app')

@if (isset($task))
@section ('title', trans('labels.backend.tasks.management') . ' | ' . trans('labels.backend.tasks.edit'))
@else
@section ('title', trans('labels.backend.tasks.management') . ' | ' . trans('labels.backend.tasks.create'))
@endif

@section('page-header')
    <h1>
        {{ trans('labels.backend.tasks.management') }}
        @if (isset($task))
        <small>{{ trans('labels.backend.tasks.edit') }}</small>
        @else
        <small>{{ trans('labels.backend.tasks.create') }}</small>
        @endif
        
    </h1>
@endsection

@section('content')
    @if (isset($task))
    {{ Form::model($task,['route' => ['admin.tasks.update',$task], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'update-task','enctype' => 'multipart/form-data']) }}
    @else
    {{ Form::open(['route' => 'admin.tasks.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-task','enctype' => 'multipart/form-data']) }}    
    @endif
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ isset($task) ? trans('labels.backend.tasks.edit') : trans('labels.backend.tasks.create') }}</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title', trans('validation.attributes.backend.tasks.title'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.tasks.title'), 'required' => 'required']) }}
                    </div>
                </div>

                <div class="form-group">
					{{ Form::label('task_file', trans('validation.attributes.backend.tasks.task_file'), ['class' => 'col-lg-2 control-label']) }}

					<div class="col-lg-10">

						<div class="custom-file-input">
							{{ Form::file('task_file', array('class'=>'form-control inputfile inputfile-1' )) }}
							<label for="task_file">
								<i class="fa fa-upload"></i>
								<span>Choose a file</span>
							</label>
                        </div>
                        <div class="img-remove-logo">
							@if(isset($task) && $task->task_file)
							<img width="200" src="{{ Storage::disk('public')->url('app/public/img/tasks/' . $task->task_file) }}">
							{{-- <i id="remove-logo-img" class="fa fa-times remove-logo" data-id="task_file" aria-hidden="true"></i> --}}
							@endif
						</div>
					</div>
                </div>
                
                <div class="form-group">
                    {{ Form::label('is_featured', trans('validation.attributes.backend.tasks.is_featured'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div class="control-group">
                            <label class="control control--checkbox">
                                {{ Form::checkbox('is_featured', 1) }}
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('status', trans('validation.attributes.backend.tasks.status'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::select('status', [1 => 'Active', 2 => 'Inactive'], null ,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.tasks.status_placeholder'), 'required' => 'required']) }}
                    </div>
                </div>

                <div class="edit-form-btn">
                    {{ link_to_route('admin.tasks.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    @if (isset($task))
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    @else
                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('after-scripts')
<script>
    $('.remove-logo').click(function() {
        //add code to remove the logo
    });
</script>    
@endsection