@extends('backend.admin.layouts.app')

@section('meta_title', 'Admin Users')
@section('page_title', 'Admin Users')
@section('page_title_icon')
<i class="metismenu-icon pe-7s-users"></i>
@endsection

@section('page_title_buttons')
<div class="d-flex justify-content-end">
    <div class="custom-control custom-switch p-2 mr-3">
        <input type="checkbox" class="custom-control-input trashswitch" id="trashswitch">
        <label class="custom-control-label" for="trashswitch"><strong>Trash</strong></label>
    </div>

    {{-- @can('add_admin_user') --}}
    <a href="{{route('admin.admin-users.create')}}" title="Add Admin User" class="btn btn-primary action-btn">Add Admin User</a>
    {{-- @endcan --}}
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-hover data-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th class="no-sort action">Action</th>
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
var route_model_name = "admin-users";
var app_table;
$(function() {
    app_table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${PREFIX_URL}/admin/${route_model_name}?trash=0`,
        columns: [
            {data: "plus-icon", name: "plus-icon", defaultContent: null},
            {data: 'name', name: 'name', defaultContent: "-", class: ""},
            {data: 'email', name: 'email', defaultContent: "-", class: ""},
            {data: 'roles', name: 'roles', defaultContent: "-", class: ""},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at', defaultContent: null}
        ],
        order: [
            [5, 'desc']
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
});
</script>
@include('backend.admin.layouts.assets.trash_script')
@endsection
