<?php

declare(strict_types=1);

namespace app\services;

use app\models\Link;
use app\models\Product;
use app\models\Store;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\RequestException;
use Yii;
use yii\base\ErrorException;

/**
 * Class ParserService
 *
 * @package app\services
 */
class ParserService
{

    /**
     * Генерация рандомного UserAgent
     *
     * @return string
     * @throws \Exception
     */
    private function generateUserAgent(): string
    {

        // @todo Вынести из сервиса
        $platforms_txt = "Windows NT 6.1; WOW64
Windows NT 10.0; WOW64
Windows NT 6.1
Windows NT 6.3; WOW64
X11; Ubuntu; Linux x86_64
Windows NT 10.0; Win64; x64
Macintosh; Intel Mac OS X 10.11
Windows NT 10.0
Windows NT 6.2; WOW64
Windows NT 6.0
Macintosh; Intel Mac OS X 10.10
X11; Linux x86_64
Windows NT 6.2
Macintosh; Intel Mac OS X 10.9
Macintosh; Intel Mac OS X 10.6
Windows NT 6.1; Win64; x64
Macintosh; Intel Mac OS X 10.8
X11; Linux i686
Macintosh; Intel Mac OS X 10.7
Windows NT 5.1; WOW64
Windows NT 5.1
Windows NT 6.3; Win64; x64
Windows NT 6.3
Windows NT 6.0; WOW64
Macintosh; Intel Mac OS X 10.12
Windows NT 6.2; Win64; x64";

        $platforms = explode("\n", $platforms_txt);

        $ver = random_int(55, 59);
        $platform = trim(
                $platforms[random_int(0, count($platforms) - 1)]
            )."; rv:$ver.0";

        return "Mozilla/5.0 ($platform) Gecko/20100101 Firefox/$ver.0";
    }

    /**
     * @param $url
     * @param string $type
     *
     * @return false|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function getPage(string $url, string $type = 'curl')
    {

        try {

            $data = '';
            switch ($type) {
                case 'curl':
                    $headers = [
                        'User-Agent' => $this->generateUserAgent(),
                        'accept-language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                        'cache-control' => 'no-cache',
                        'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                        'pragma' => 'no-cache',
                    ];

                    $cookieFile = Yii::getAlias(
                            '@app'
                        ).'/web/uploads/cookie_jar.txt';
                    $cookieJar = new FileCookieJar($cookieFile, true);

                    // Guzzle Client
                    $client = new Client(
                        [
                            'headers' => $headers,
                            'timeout' => 10,
                            'cookies' => $cookieJar,
                        ]
                    );

                    $response = $client->request('GET', $url);

                    $data = $response->getBody();

                    unset($client, $response);

                    break;

                case 'js':
                    exec(
                        'export QT_QPA_PLATFORM="offscreen" && /usr/bin/phantomjs '.Yii::getAlias(
                            '@webroot'
                        ).'/download.js '.$url.' --cookies-file=/var/www/parser/web/uploads/cookie_jar.txt',
                        $return
                    );

                    $path = Yii::getAlias('@app').'/web/uploads/cache/';
                    $filename = 'debugjs.html';

                    if (file_exists($path.$filename)) {
                        $data = file_get_contents($path.$filename);
                    } else {
                        return false;
                    }

                    break;

            }

            Yii::debug('время - '.date('d.m.Y H:i', time()));
            Yii::debug('память - '.memory_get_usage(true));

            return $data;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Yii::error($e->getResponse());
            }

            return false;
        }
    }

    /**
     * @param $url
     * @param $type
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getPq($url, $type)
    {

        try {

            $path = Yii::getAlias('@app').'/web/uploads/cache/';
            $filename = urlencode($url);
            $exist = false;

            // Если файл существует, проверяем дату изменения
            if (file_exists($path.$filename)) {
                $fileTime = filemtime($path.$filename);
                if (time() < ($fileTime + 3600 * 24)) {
                    $exist = true;
                }
            }

            if ($exist) {
                $data = file_get_contents($path.$filename);
            } else {
                $data = $this->getPage($url, $type);

                if (!$data) {
                    return false;
                }

                // Сохраняем файл в кеш
                file_put_contents($path.$filename, $data);

            }

            return \phpQuery::newDocument('<meta charset="utf-8">'.$data);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                Yii::error($e->getResponse());
            }

            return false;
        }

    }

    /**
     * Разбор страницы по тегам
     *
     * @param \app\models\Link $linkModel
     * @param \app\models\Store $storeModel
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function parserPq(Link $linkModel, Store $storeModel): void
    {

        $pq = $this->getPq($linkModel->link, $storeModel->js ? 'js' : 'curl');

        if (!$pq) {
            return;
        }

        $productModel = new Product();
        $productModel->linkId = $linkModel->id;

        $productModel->name = trim(
            strip_tags($pq->find($storeModel->tag_name)->html())
        );

        if (!empty($storeModel->tag_text)) {
            $text = trim(
                strip_tags($pq->find($storeModel->tag_text)->eq(0)->html())
            );
            $productModel->text = preg_replace('/ {2,}/', ' ', $text);
        }

        if (!empty($storeModel->tag_image)) {
            $productModel->image = $storeModel->url.$pq->find(
                    $storeModel->tag_image
                )
                    ->attr('src'); // Изображения
        }

        if (!empty($storeModel->tag_price)) {
            $price = trim($pq->find($storeModel->tag_price)->text()); // Цены
            $productModel->price = $price;
        }

        if (!empty($storeModel->tag_action)) {
            $productModel->action = trim(
                $pq->find($storeModel->tag_action)->text()
            );
        }
        if (!empty($storeModel->tag_availability)) {
            $productModel->availability = trim(
                $pq->find($storeModel->tag_availability)->text()
            );
        }

        if (!empty($storeModel->tag_rating)) {
            $rating = trim(
                $pq->find($storeModel->tag_rating)->text()
            ); // Рейтинга
            $rating = str_replace(['.0%', ' '], '', $rating);
            $productModel->rating = $rating;
        }

        if (!empty($storeModel->tag_reviews)) {
            $productModel->reviews = trim(
                strip_tags($pq->find($storeModel->tag_reviews)->text())
            );
        }

        \phpQuery::unloadDocuments();

        Yii::debug('Сохранение результата - '.$linkModel->link);
        if (!$productModel->save()) {
            Yii::debug('Ошибка сохранения - '.$linkModel->link);
            $error = json_encode(
                $productModel->getErrors(),
                JSON_UNESCAPED_UNICODE
            );
            throw new \Error($error);
        }

    }

    /**
     * @param int $storeId
     *
     *
     * @throws \yii\base\ErrorException|\GuzzleHttp\Exception\GuzzleException
     */
    public function process(int $storeId): void
    {

        /** @var Store $storeModel */
        $storeModel = Store::find()->where(['id' => $storeId])->one();

        if (!$storeModel) {
            throw new ErrorException('Настройки магазина не найдены');
        }

        /** @var Link $link */
        foreach ($storeModel->links as $linkModel) {

            Yii::debug($linkModel->link);

            // Парсинг страницы
            $this->parserPq($linkModel, $storeModel);

        }

    }

}
