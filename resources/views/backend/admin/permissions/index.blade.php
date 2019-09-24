@extends('backend.admin.layouts.app')

@section('meta_title', 'Permissions')
@section('page_title', 'Permissions')
@section('page_title_icon')
<i class="metismenu-icon pe-7s-door-lock"></i>
@endsection

@section('page_title_buttons')
<div class="d-flex justify-content-end">
    {{-- @can('add_permission') --}}
    <a href="{{route('admin.permissions.create')}}" title="Add Permission" class="btn btn-primary action-btn">Add Permission</a>
    {{-- @endcan --}}
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><span class="type">Admin</span>&nbsp;Permissions
                <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button class="active btn btn-warning btn-action-group" data-guard="admin">Admin</button>
                        <button class="btn btn-warning btn-action-group" data-guard="web">Client</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none hidden">Updated at</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(function() {
    var app_table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.permissions.index') }}?guard=admin",
        columns: [
            {data: 'name', name: 'name', defaultContent: "-", class: ""},
            {data: 'updated_at', name: 'updated_at', defaultContent: null}
        ],
        order: [
            [1, 'desc']
        ],
        responsive: {
            details: {type: "column", target: 0}
        },
        columnDefs: [
            {targets: "no-sort", orderable: false},
            {className: "control", orderable: false, targets: 0},
            {targets: "hidden", visible: false}
        ],
        pagingType: "simple_numbers",
        language: {
            paginate: {previous: "«", next: "»"},
            processing: `<div class="processing_data">
                <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div></div>`
        }
    });

    $(document).on('click', '.btn-action-group', function() {
        $(this).addClass('active');
        $(this).siblings('.btn-action-group').removeClass('active');
        let guard = $(this).data('guard');
        let type = 'Client';
        if(guard == 'admin') {
            type = 'Admin'
        }
        $('.type').text(type);
        app_table.ajax.url("{{ route('admin.permissions.index') }}?guard=" + guard).load();
    });
});
</script>
@endsection