<?php
/** @var string $id */
/** @var ActiveField $field */
/** @var string[] $years */
/** @var string[] $months */
/** @var string[] $days */
/** @var int $currentYear */
/** @var int $currentMonth */
/** @var int $currentDay */

use yii\helpers\Html;
use yii\widgets\ActiveField;

?>

<div id="<?= $id ?>" class="form-group">

	<?= Html::label($field->model->getAttributeLabel($field->attribute), null, ['class' => 'control-label']) ?>&nbsp;

	<?= Html::dropDownList(Html::getInputName($field->model, $field->attribute . '_day'), $currentDay, $days, ['data-role' => 'daySelector', 'class' => 'btn btn-default']) ?>

	<?= Html::dropDownList(Html::getInputName($field->model, $field->attribute . '_month'), $currentMonth, $months, ['data-role' => 'monthSelector', 'class' => 'btn btn-default']) ?>

	<?= Html::dropDownList(Html::getInputName($field->model, $field->attribute . '_year'), $currentYear, $years, ['data-role' => 'yearSelector', 'class' => 'btn btn-default']) ?>

	<?= $field->hiddenInput(['data-role' => 'hiddenResultValue'])->label(false) ?>

</div>