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

	if (Yii::$app->authManager->getAssignment(AclHelper::ROLE_ADMIN, \Yii::$app->user->id) !== null) {
		$attributes = [
				'id',
				'authorName',
				'name',
				'surname',
				'phoneFront',
				'email',
				[
						'attribute' => 'cityTitle',
						'value'     => (($model->city !== null) ? $model->city->formalname : ''),
				],
				[
						'attribute' => 'streetTitle',
						'value'     => (($model->street !== null) ? $model->street->formalname : ''),
				],
				'house',
				'appartment',
				[
						'attribute' => 'create_stamp',
						'format'    => 'localDate',
				],
				[
						'attribute' => 'update_stamp',
						'format'    => 'localDate',
				],
		];
	}
	else {
		$attributes = [
				'id',
				'name',
				'surname',
				[
						'class'     => 'yii\grid\DataColumn',
						'attribute' => 'phone',
						'format'    => 'phoneVisual',
				],
				'email',
				[
						'attribute' => 'cityTitle',
						'value'     => (($model->city !== null) ? $model->city->formalname : ''),
				],
				[
						'attribute' => 'streetTitle',
						'value'     => (($model->street !== null) ? $model->street->formalname : ''),
				],
				'house',
				'appartment',
				[
						'attribute' => 'create_stamp',
						'format'    => 'localDate',
				],
				[
						'attribute' => 'update_stamp',
						'format'    => 'localDate',
				],
		];
	} ?>

	<?= DetailView::widget([
			'model'      => $model,
			'attributes' => $attributes,
			'formatter'      => [
					'class'      => app\components\Formatter::class,
					'dateFormat' => 'd.m.Y H:i',
			],
	]) ?>

</div>
