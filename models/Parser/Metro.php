<?php

namespace app\models\Parser;


class Metro extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->image = $pq->find('.image-container img')->attr('src');

    }

}