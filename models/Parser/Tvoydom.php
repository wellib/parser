<?php

namespace app\models\Parser;


class Tvoydom extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->rating = trim(' ' . $pq->find('.item-inner__main .item__rating .glyphicon-star.active')->length());

    }

}