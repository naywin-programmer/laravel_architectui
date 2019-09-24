@extends('backend.admin.layouts.app')

@section('meta_title', 'Add Permission')
@section('page_title', 'Add Permission')
@section('page_title_icon')
<i class="metismenu-icon pe-7s-lock"></i>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form action="{{ route('admin.permissions.store') }}" method="post" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guards">Guard</label>
                                <select class="form-control select2" name="guards[]" id="guards" multiple>
                                    @foreach($guards as $guard_alias => $guard_name)
                                        <option value="{{$guard_name}}">{{$guard_alias}} ({{$guard_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-danger mr-5">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\StorePermission', '#form') !!}
@endsection