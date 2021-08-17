<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Магазины';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">

    <div class="box-body">

        <p>
            <?= Html::a('Выгрузить все', \yii\helpers\Url::to(['/parser']), ['class' => 'btn btn-success']) ?>
            <?= Html::a('Очистить кэш', \yii\helpers\Url::to(['/parser/clean-cache']), ['class' => 'btn btn-danger']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                [
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a('Выгрузить', \yii\helpers\Url::to(['/parser', 'id' => $data->id]));
                    }
                ],


            ],
        ]); ?>

    </div>
</div>