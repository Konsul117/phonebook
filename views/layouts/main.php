<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
//use app\assets\AppAsset;
use app\assets\MyAsset;

/* @var $this \yii\web\View */
/* @var $content string */

//AppAsset::register($this);
MyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			
			$nav_items = [
                    ['label' => 'Contact', 'url' => ['/contact/index']],
                ];
			
			if(Yii::$app->user->isGuest) {
				$nav_items[] = ['label' => 'Login', 'url' => ['/user/login']];
				$nav_items[] = ['label' => 'Register', 'url' => ['/user/register']];
			} else {
				$nav_items[] = ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/logout'],
                            'linkOptions' => ['data-method' => 'post']];
			}
			
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $nav_items,
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
