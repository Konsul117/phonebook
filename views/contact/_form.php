<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 100])->label('Имя') ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => 100])->label('Фамилия') ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 45, 'class' => 'form-control phone_field'])->label('Телефон') ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 100])->label('Адрес') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['/'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
