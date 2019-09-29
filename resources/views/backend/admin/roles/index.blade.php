@extends('backend.admin.layouts.app')

@php
$page_name = 'Users Roles';
if(request('guard') == 'admin') {
    $page_name = 'Admin Users Roles';
}
@endphp

@section('meta_title', $page_name)
@section('page_title', $page_name)
@section('page_title_icon')
<i class="metismenu-icon pe-7s-helm"></i>
@endsection

@section('page_title_buttons')
<div class="d-flex justify-content-end">
    {{-- @can('add_role') --}}
    <a href="{{route('admin.roles.create')}}?guard={{request('guard')}}" title="Add Role" class="btn btn-primary action-btn">Add Role</a>
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
$(function() {
    var app_table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.roles.index') }}?guard={{request('guard')}}",
        columns: [
            {data: "plus-icon", name: "plus-icon", defaultContent: null},
            {data: 'name', name: 'name', defaultContent: "-", class: ""},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at', defaultContent: null}
        ],
        order: [
            [3, 'desc']
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

    $(document).on('click', '.destroy', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `${PREFIX_URL}/admin/roles/${id}`,
            method: 'DELETE',
            data: {'_token': CSRF_TOKEN},
            success: function(data) {
                app_table.ajax.reload();
            }
        });
    });
});
</script>
@endsection