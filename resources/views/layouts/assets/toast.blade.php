<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
$(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    @if(session('success'))
    Toast.fire({
        type: 'success',
        title: '{{ session("success") }}'
    })
    @php
    Session::forget('success');
    @endphp
    @endif

    @if(session('error'))
    Toast.fire({
        type: 'error',
        title: '{{ session("error") }}'
    })
    @php
    Session::forget('error');
    @endphp
    @endif
});
</script>