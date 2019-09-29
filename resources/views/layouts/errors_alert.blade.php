@if($errors->any())
<div class="row">
    <div class="col-md-12">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <strong>{{$error}}</strong>
        </div>
        @endforeach
    </div>
</div>
@endif