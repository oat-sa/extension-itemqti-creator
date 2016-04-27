<?php
use oat\tao\helpers\Template;
use oat\tao\helpers\Layout;
use oat\tao\model\theme\Theme;

$contentTemplate = Layout::getContentTemplate();
?>
<!doctype html>
<html class="no-js">
<head>
    <script src="<?= Template::js('lib/modernizr-2.8/modernizr.js', 'tao')?>"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Layout::getTitle() ?></title>
    <link rel="shortcut icon" href="<?= Template::img('img/favicon.ico') ?>"/>
    <link rel="stylesheet" href="<?= Template::css('preview.css','taoItems') ?>" />
    <?= tao_helpers_Scriptloader::render() ?>
    <?= Layout::getAmdLoader() ?>

    <link rel="stylesheet" href="<?= Layout::getThemeStylesheet(Theme::CONTEXT_BACKOFFICE) ?>" />
</head>

<body>
    <div class="content-wrap">
        <div id="feedback-box"></div>
        <?php Template::inc($contentTemplate['path'], $contentTemplate['ext']); ?>
    </div>
    <div class="loading-bar"></div>
</body>
</html>
