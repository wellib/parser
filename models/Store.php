<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string $name
 * @property string $options
 * @property string $url
 * @property string $tag_name
 * @property string $tag_text
 * @property string $tag_image
 * @property string $tag_price
 * @property string $tag_action
 * @property string $tag_availability
 * @property string $tag_rating
 * @property string $tag_reviews
 * @property string $tag_position
 * @property string $class_name
 * @property int $js
 *
 */
class Store extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['options'], 'string'],
            [['name', 'class_name', 'url'], 'string', 'max' => 255],
            [['name'], 'unique'],

            [
                [
                    'tag_text',
                    'tag_name',
                    'tag_image',
                    'tag_price',
                    'tag_action',
                    'tag_availability',
                    'tag_rating',
                    'tag_reviews',
                    'tag_position',
                ],
                'string',
                'max' => 255,
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'url' => 'Ссылка',
            'class_name' => 'Класс доп. обработки (при наличии)',
            'js' => 'Обработка PhantomJs',
            'options' => 'Настройки',
            'tag_name' => 'Селектор Названия',
            'tag_text' => 'Селектор Описания',
            'tag_image' => 'Селектор Изображения',
            'tag_price' => 'Селектор Цены',
            'tag_action' => 'Селектор Акции',
            'tag_availability' => 'Селектор Наличия',
            'tag_rating' => 'Селектор Рейтинга',
            'tag_reviews' => 'Селектор Отзывы',
            'tag_position' => 'Селектор Ссылок в категории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Link::class, ['store_id' => 'id']);
    }

}
