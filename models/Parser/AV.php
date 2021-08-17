<?php

namespace app\models\Parser;


class AV extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->price = $pq->find('.b-goods-price__value span')->attr('content');
        $product->rating = $pq->find('.b-product-reviews__panel .b-ui-stars')->attr('data-value');

    }

}