@extends('backend.admin.layouts.app')

@php
$page_name = 'Edit Users Roles';
if(request('guard') == 'admin') {
    $page_name = 'Edit Admin Users Roles';
}
@endphp

@section('meta_title', $page_name)
@section('page_title', $page_name)
@section('page_title_icon')
<i class="metismenu-icon pe-7s-helm"></i>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form action="{{ route('admin.roles.update', ['role' => $role->id]) }}?guard={{request('guard')}}" method="post" id="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$role->name}}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="d-block">Permissions</label>
                                @forelse($permissions as $permission)
                                <div class="form-check form-check-inline mt-2">
                                    <div class="chiller_cb">
                                        <input id="{{$permission->name}}" type="checkbox" name="permissions[]" value="{{$permission->name}}" @if($role->hasPermissionTo($permission->name)) checked @endif />
                                        <label for="{{$permission->name}}" class="h6">{{$permission->name}}</label>
                                        <span></span>
                                    </div>
                                </div>
                                @empty
                                    <p class="text text-danger">No Permission Found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('admin.roles.index') }}?guard={{request('guard')}}" class="btn btn-danger mr-5">Cancel</a>
                            <input type="submit" value="Add" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\UpdateRole', '#form') !!}
@endsection