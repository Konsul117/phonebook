<?php

use app\models\Contact;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Contact */
/* @var $form ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'contactForm', 'autocomplete' => 'off']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 100])->label('Имя') ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => 100])->label('Фамилия') ?>

    <?= $form->field($model, 'phoneFront')->textInput(['maxlength' => 45, 'class' => 'form-control phone_field']) ?>

    <?= $form->field($model, 'cityTitle')->textInput(['maxlength' => 100, 'data-role' => 'city_selector', 'autocomplete'=>'off']) ?>

	<?= $form->field($model, 'city_guid')->hiddenInput(['id' => 'cityGuid'])->label(false) ?>

    <?//= $form->field($model->street, 'formalname')->textInput(['maxlength' => 100, 'data-role' => 'street_selector']) ?>

    <?= $form->field($model, 'street_guid')->hiddenInput(['id' => 'streetGuid'])->label(false) ?>

    <?= $form->field($model, 'streetTitle')->textInput(['maxlength' => 100, 'data-role' => 'street_selector', 'autocomplete'=>'off']) ?>

    <div class="form-group">

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?/*= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
        <?= Html::a('Отмена', ['/'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	<? $this->registerJs('$(\'#contactForm\').contactForm();') ?>

</div>
