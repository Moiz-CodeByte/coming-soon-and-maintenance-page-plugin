jQuery(document).ready(function($) {
    $('#csp_is_active').change(function() {
        if ($(this).is(':checked')) {
            $('.csp-settings-options').show();
        } else {
            $('.csp-settings-options').hide();
        }
    });
});
