<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $store_id
 * @property string $name
 * @property string $link
 * @property string $link_category
 * @property string $tag_name
 * @property string $tag_text
 * @property string $tag_image
 * @property string $tag_price
 * @property string $tag_action
 * @property string $tag_availability
 * @property string $tag_rating
 * @property string $tag_reviews
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'name', 'link'], 'required'],
            [['link', 'link_category'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['store_id'], 'integer'],
            [['link'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Магазин',
            'name' => 'Название',
            'link' => 'Ссылка на товар',
            'link_category' => 'Ссылка на категорию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }
}
