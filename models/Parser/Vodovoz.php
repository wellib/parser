<?php

namespace app\models\Parser;


class Vodovoz extends Parser
{

    public function run(&$product) {

        $pq = $this->pq;
        $product->rating = '' . $pq->find('#main_unit .star-active.star-voted')->length();
		$product->reviews = trim(iconv("UTF-8//IGNORE", "ISO-8859-1//IGNORE", strip_tags($pq->find('#a_comment_list .comment_content>div')->html()))); // Отзывы
					
    }

}