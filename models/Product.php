<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $linkId
 * @property string $name
 * @property string $text
 * @property string $image
 * @property string $price
 * @property string $action
 * @property string $availability
 * @property string $rating
 * @property string $reviews
 * @property int $createdAt
 * @property int $updatedAt
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['linkId'], 'required'],
            [['linkId'], 'integer'],
            [['text', 'reviews'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'image', 'price', 'action', 'availability', 'rating'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'linkId' => 'Ссылка',
            'name' => 'Название',
            'text' => 'Описание',
            'image' => 'Изображение',
            'price' => 'Цена',
            'action' => 'Акции',
            'availability' => 'Наличие',
            'rating' => 'Рейтинг',
            'reviews' => 'Отзывы',
            'position' => 'Позиция',
            'created_at' => 'Выгружено',
            // 'updated_at' => 'Изменен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(LInk::class, ['id' => 'linkId']);
    }

}
