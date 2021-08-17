<?php

namespace app\models\Parser;


class Globus extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->price = $pq->find('meta[itemprop=price]')->attr('content');
        $product->image = $pq->find('.slider_gallery_large img')->attr('src');

    }

}