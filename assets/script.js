jQuery(document).ready(function($) {
    $('#csmp_is_active').change(function() {
        if ($(this).is(':checked')) {
            $('.csmp-settings-options').show();
        } else {
            $('.csmp-settings-options').hide();
        }
    });
});
