@extends('backend.admin.layouts.app')

@section('meta_title', 'Add Category')
@section('page_title', 'Add Category')
@section('page_title_icon')
<i class="pe-7s-menu icon-gradient bg-ripe-malin"></i>
@endsection

@php
$encoded = json_decode($category->name);
@endphp

@section('content')
@include('layouts.errors_alert')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="post" id="form">
                    @csrf
                    @method("PUT")
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_my">Name (Burmese)</label>
                                <input type="text" name="name_my" id="name_my" class="form-control" value="{{$encoded->my}}" autofocus>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_en">Name (English)</label>
                                <input type="text" name="name_en" id="name_en" class="form-control" value="{{$encoded->en}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Link (Optional)</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{$category->slug}}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rank">Rank</label>
                                <input type="number" name="rank" id="rank" class="form-control" value="{{$category->rank}}" min="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id">Main Category (Optional)</label>
                                <select class="form-control select2" name="parent_id" id="parent_id">
                                    <option value=""></option>
                                    @foreach($main_categories as $each_category)
                                        @php
                                        $category_decoded = json_decode($each_category->name);
                                        @endphp
                                        <option value="{{$each_category->id}}" @if($each_category->id == $category->parent_id) selected @endif>{{$category_decoded->my}} ({{$category_decoded->en}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-danger mr-5">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateCategory', '#form') !!}
@endsection