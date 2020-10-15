<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <nav class="main-header">

    </nav>

    <aside class="main-sidebar">
        <ul>
            <li>
                <a href="/" title="Home">
                    <img src="/img/logo.png">
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['site/about']) ?>" title="Home">
                    <img src="/img/faq.png"><br>
                    <span>FAQ</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main-content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
