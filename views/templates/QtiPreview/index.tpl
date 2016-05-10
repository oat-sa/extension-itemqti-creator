<script>
requirejs.config({
    config : {
        'itemqtiCreator/qtiPreview/previewLauncher' : {
            previewUrl : <?= json_encode(get_data('previewUrl')) ?>
        }
    }
});
</script>
