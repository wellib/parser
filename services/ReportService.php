<?php

declare(strict_types=1);

namespace app\services;

class ReportService
{

    /**
     * Выгрузка в excel
     *
     * @param $ids
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function export($ids): void
    {

        $file = \Yii::createObject(
            [
                'class' => 'codemix\excelexport\ExcelFile',
                'sheets' => [
                    'Users' => [
                        'class' => 'codemix\excelexport\ActiveExcelSheet',
                        'query' => Product::find()->where(
                            ['in', 'id', $ids]
                        ),
                        'attributes' => [
                            'link.store.name',
                            'name',
                            'image',
                            'price',
                            'action',
                            'availability',
                            'rating',
                            'text',
                            'reviews',
                            'position',
                            'link.link',
                        ],
                    ],
                ],
            ]
        );

        $filename = 'export_'.time().'.xlsx';

        $file->send($filename);

    }
}
