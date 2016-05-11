<script>
requirejs.config({
    config : {
        'itemqtiCreator/qtiPreview/previewLauncher' : {
            previewUrl : <?= json_encode(get_data('previewUrl')) ?>,
            returnUrl  : <?= json_encode(get_data('returnUrl')) ?>
        }
    }
});
</script>
