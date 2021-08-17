<?php

namespace app\models\Parser;


class Utkonos extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->rating = $pq->find('.goods_view_item-side .rating_star .selected')->attr('data-ratingpos');
		if ($product->price == '') {
			$price = trim($pq->find('.goods_view_item-side .goods_price-item.current')->text()); // Цены
            $price = str_replace(['₽', ' ', ','], ['', '', '.'], $price);
            $product->price = $price;
		}
    }

}
