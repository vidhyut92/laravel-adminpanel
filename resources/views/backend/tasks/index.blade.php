@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.tasks.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.tasks.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.tasks.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.tasks.partials.tasks-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="tasks-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.tasks.table.title') }}</th>
                            <th>{{ trans('labels.backend.tasks.table.status') }}</th>
                            <th>{{ trans('labels.backend.tasks.table.is_featured') }}</th>
                            <th>{{ trans('labels.backend.tasks.table.createdat') }}</th>
                            <th>{{ trans('labels.backend.tasks.table.createdby') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>
                                {!! Form::text('first_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.tasks.table.title')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::select('status', [2 => "InActive", 1 => "Active"], null, ["class" => "search-input-select form-control", "data-column" => 1, "placeholder" => trans('labels.backend.tasks.table.all')]) !!}
                            </th>
                            <th>
                                {!! Form::select('is_featured', [0 => "No", 1 => "Yes"], null, ["class" => "search-input-select form-control", "data-column" => 2, "placeholder" => trans('labels.backend.tasks.table.all')]) !!}
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
        </div><!-- /.box-header -->
        <div class="box-body">
            {{-- {!! history()->renderType('CMSpage') !!} --}}
        </div><!-- /.box-body -->
    </div><!--box box-info-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            var dataTable = $('#tasks-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.tasks.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: '{{config('module.tasks.table')}}.title'},
                    {data: 'status', name: '{{config('module.tasks.table')}}.status'},
                    {data: 'is_featured', name: '{{config('module.tasks.table')}}.is_featured'},
                    {data: 'created_at', name: '{{config('module.tasks.table')}}.created_at'},
                    {data: 'created_by', name: '{{config('access.users_table')}}.first_name'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[1, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection