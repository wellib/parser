<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ссылка', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render(
            '_form',
            [
                'model' => $model,
            ]
        ) ?>
    </div>
</div>
