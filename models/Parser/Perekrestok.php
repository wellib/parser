<?php

namespace app\models\Parser;


class Perekrestok extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
		if ($product->price == '') {
			$price = $pq->find('.xf-price.xf-product-cost__current')->attr('data-cost'); // Цены
			$price = str_replace(',', '.', $price);
			$product->price = $price;	
		}
    }

}