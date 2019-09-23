<script>
var PREFIX_URL = '{{config("app.prefix_admin_url")}}';
var CSRF_TOKEN = '{{csrf_token()}}';
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/assets/scripts/main.js') }}"></script>
<script src="{{ asset('vendor/assets/scripts/script.js') }}"></script>
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@include('layouts.assets.select2')
@include('layouts.assets.toast')
@yield('script')