<?php

use app\components\AclHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Правка', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data'  => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method'  => 'post',
				],
		]) ?>
	</p>

	<?php
	$attributes = [
			'id',
			'authorName',
			'name',
			'surname',
			'phone',
			'address',
			'create_stamp',
			'update_stamp',
	];

	if (Yii::$app->authManager->getAssignment(AclHelper::ROLE_ADMIN, \Yii::$app->user->id) !== null) {
		$attributes = [
				[
						'attribute' => 'id',
						'label'     => '№',
				],
				'authorName',
				'name',
				'surname',
				'phone',
				'address',
				'create_stamp',
				'update_stamp',
		];
	}
	else {
		$attributes = [
				[
						'attribute' => 'id',
						'label'     => '№',
				],
				'name',
				'surname',
				'phone',
				'address',
				'create_stamp',
				'update_stamp',
		];
	} ?>

	<?= DetailView::widget([
			'model'      => $model,
			'attributes' => $attributes,
	]) ?>

</div>
