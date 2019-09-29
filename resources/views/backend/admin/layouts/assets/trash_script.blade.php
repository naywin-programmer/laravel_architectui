<script>
$(function() {
    $(document).on('click', '.destroy', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `${PREFIX_URL}/admin/${route_model_name}/${id}`,
            method: 'DELETE',
            data: {'_token': CSRF_TOKEN},
            success: function(data) {
                app_table.ajax.reload();
            }
        });
    });

    $(document).on('change', '.trashswitch', function() {
        if ($(this).prop('checked') == true) {
            var trash = 1;
        } else {
            var trash = 0;
        }
        app_table.ajax.url(`${PREFIX_URL}/admin/${route_model_name}?trash=${trash}`).load();
    });

    $(document).on('click', '.trash', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `${PREFIX_URL}/admin/${route_model_name}/${id}/trash`,
            method: 'PUT',
            data: {'_token': CSRF_TOKEN},
            success: function(data) {
                app_table.ajax.reload();
            }
        });
    });

    $(document).on('click', '.restore', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `${PREFIX_URL}/admin/${route_model_name}/${id}/restore`,
            method: 'PUT',
            data: {'_token': CSRF_TOKEN},
            success: function(data) {
                app_table.ajax.reload();
            }
        });
    });
});
</script>