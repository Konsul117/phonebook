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
				[
						'attribute' => 'id',
						'label'     => '№',
				],
				[
						'attribute' => 'author_id',
						'value'     => (($model->author !== null) ? $model->author->username : ''),
				],
				'name',
				'surname',
				'phone',
				[
						'attribute' => 'city_guid',
						'value'     => (($model->city !== null) ? $model->city->formalname : ''),
				],
				[
						'attribute' => 'street_guid',
						'value'     => (($model->street !== null) ? $model->street->formalname : ''),
				],
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
				[
						'attribute' => 'city_guid',
						'value'     => (($model->city !== null) ? $model->city->formalname : ''),
				],
				[
						'attribute' => 'street_guid',
						'value'     => (($model->street !== null) ? $model->street->formalname : ''),
				],
				'create_stamp',
				'update_stamp',
		];
	} ?>

	<?= DetailView::widget([
			'model'      => $model,
			'attributes' => $attributes,
	]) ?>

</div>
