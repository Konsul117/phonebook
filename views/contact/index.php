<?php

use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\grid\GridView;

//use \nterms\pagesize\PageSize;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php
	if (Yii::$app->authManager->getAssignment('admin', \Yii::$app->user->id) !== null) {
		$grid_columns = [
				['class' => 'yii\grid\SerialColumn'],
				'authorName',
				'name',
				'surname',
				[
						'class'     => 'yii\grid\DataColumn',
						'attribute' => 'phone',
						'format'    => 'phoneVisual',
				],
				'cityTitle',
				'streetTitle',
				[
						'class'     => DataColumn::class,
						'attribute' => 'create_stamp',
						'format'    => 'localDate',
				],
				[
						'class'     => DataColumn::class,
						'attribute' => 'update_stamp',
						'format'    => 'localDate',
				],
				['class' => 'yii\grid\ActionColumn'],
		];
	}
	else {
		$grid_columns = [
				['class' => 'yii\grid\SerialColumn'],
				'name',
				'surname',
				[
						'class'     => 'yii\grid\DataColumn',
						'attribute' => 'phone',
						'format'    => 'phoneVisual',
				],
				'cityTitle',
				'streetTitle',
				[
						'class'     => 'yii\grid\DataColumn',
						'attribute' => 'create_stamp',
						'format'    => 'localDate',
				],
				[
						'class'     => 'yii\grid\DataColumn',
						'attribute' => 'update_stamp',
						'format'    => 'localDate',
				],
				['class' => 'yii\grid\ActionColumn'],
		];
	}
	?>


	<?=
	GridView::widget([
			'dataProvider'   => $dataProvider,
			'filterModel'    => $searchModel,
			'columns'        => $grid_columns,
			'layout'         => "{pager}\n{summary}\n{items}\n{pager}",
			'formatter'      => [
					'class'      => app\components\Formatter::class,
					'dateFormat' => 'd.m.Y H:i',
			],
			'filterSelector' => 'select[name="per-page"]',
	])
	?>

</div>
