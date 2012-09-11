<?php
use Axelarge\TempPlate\Template;
use Axelarge\TempPlate\ViewContext;

return Template::create(function (ViewContext $view) { ?>
<body>

<div class="content" style="width: 1000px; margin: auto; overflow: auto; border: 1px solid black;">
    <h1><?= $view->block('title', "Default title!") ?></h1>

    <?= $view->block('content', 'default content') ?>

    <div style="clear: both;"></div>

    <div id="footer">Footer content</div>
</div>

</body>
<?php });
