<?php

namespace app\commands;

use app\models\Link;
use app\models\Store;
use Yii;
use app\models\User;
use yii\console\Controller;

/**
 * Class InitController
 *
 * @package app\commands
 */
class InitController extends Controller
{

    /**
     * @param bool $drop
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionIndex($drop = false): void
    {
        if ($drop) {

            \Yii::$app->db->createCommand("TRUNCATE TABLE `user`")->execute();
            $user = Yii::createObject(
                [
                    'class' => User::class,
                    'email' => Yii::$app->params['admin']['email'],
                    'username' => Yii::$app->params['admin']['user'],
                    'password' => Yii::$app->params['admin']['password'],
                    'status' => 10,
                ]
            );
            $user->save();

            \Yii::$app->db->createCommand("TRUNCATE TABLE `product`")->execute();
            \Yii::$app->db->createCommand("TRUNCATE TABLE `link`")->execute();
            \Yii::$app->db->createCommand("TRUNCATE TABLE `store`")->execute();


            // Загрузка настроек магазинов и ссылок

            // Утконос
            $store = Yii::createObject(
                [
                    'class' => Store::class,
                    'id' => 1,
                    'name' => 'Утконос',
                    'class_name' => 'Utkonos',
                    'url' => 'https://www.utkonos.ru',
                    'tag_name' => 'h1',
                    'tag_text' => '.goods_view_item-side_data .goods_view_item-tabs_content',
                    'tag_image' => '.goods_view_item-side .goods_view_item-pic_main img',
                    'tag_price' => '.goods_view_item-side .goods_price-item.current',
                    'tag_action' => '.goods_view_item-side .goods_promoaction_icon',
                    'tag_availability' => '',
                    'tag_rating' => '',
                    'tag_reviews' => '.goods_view_item-comment .comment_template_list .text',
                    'tag_position' => '.goods_view_box-pic .pic_pic',
                ]
            );
            $store->save();

            // Список ссылок
            $items = [
                'https://www.utkonos.ru/item/3239210/voda-svjatoj-istochnik-gazirovannaja--6-1-5l',
                'https://www.utkonos.ru/item/3239261/voda-svjatoj-istochnik-negazirovannaja--12-0-5l',
            ];
            foreach ($items as $item) {
                $link = Yii::createObject(
                    [
                        'class' => Link::class,
                        'store_id' => 1,
                        'name' => 'Утконос',
                        'link' => $item,
                        'link_category' => 'https://www.utkonos.ru/cat/67',
                    ]
                );
                $link->save();
            }

        }
    }
}
