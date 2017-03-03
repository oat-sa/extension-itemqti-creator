<?php
use oat\tao\helpers\Template;
use oat\tao\helpers\Layout;
use oat\tao\model\theme\Theme;

$contentTemplate = Layout::getContentTemplate();
?>
<!doctype html>
<html class="no-js">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Layout::getTitle() ?></title>
    <link rel="shortcut icon" href="<?= Template::img('favicon.ico', 'tao') ?>"/>
    <link rel="stylesheet" href="<?= Template::css('preview.css','taoItems') ?>" />
    <?= tao_helpers_Scriptloader::render() ?>
    <?= Layout::getAmdLoader(Template::js('loader/backoffice.min.js', 'tao'), 'controller/backoffice') ?>

    <link rel="stylesheet" href="<?= Layout::getThemeStylesheet(Theme::CONTEXT_BACKOFFICE) ?>" />
</head>

<body>
    <?php Template::inc('blocks/requirement-check.tpl', 'tao'); ?>

    <?php /* alpha|beta|sandbox message */
    if($hasVersionWarning) {
        Template::inc('blocks/version-warning.tpl', 'tao');
    }?>
    <?php Template::inc($contentTemplate['path'], $contentTemplate['ext']); ?>
    <div id="feedback-box"></div>
    <div class="loading-bar"></div>
</body>
</html>
