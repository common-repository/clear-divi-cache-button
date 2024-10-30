function clear_divi_cache_run_cron() {
    jQuery.post(
        ajaxurl,
        {
            action: 'clear_divi_cache_run_cron',
        },
        function( response ) {
            alert( 'Divi cache has been cleared.' );
        }
    );
}