@extends('backend.admin.layouts.app')

@php
$page_name = 'Add Users Roles';
if(request('guard') == 'admin') {
    $page_name = 'Add Admin Users Roles';
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
                <form action="{{ route('admin.roles.store') }}?guard={{request('guard')}}" method="post" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="d-block">Permissions</label>
                                <div class="row">
                                @forelse($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check form-check-inline mt-2">
                                            <div class="chiller_cb">
                                                <input id="{{$permission->name}}" type="checkbox" name="permissions[]" value="{{$permission->name}}" />
                                                <label for="{{$permission->name}}" class="h6">{{$permission->name}}</label>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <p class="text text-danger">No Permission Found.</p>
                                    </div>
                                @endforelse
                                </div>
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
{!! JsValidator::formRequest('App\Http\Requests\StoreRole', '#form') !!}
@endsection