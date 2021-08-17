<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'js')->checkbox() ?>

    <?= $form->field($model, 'tag_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_text')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'tag_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_availability')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_rating')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_reviews')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_position')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
