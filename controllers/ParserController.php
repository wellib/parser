<?php

namespace app\controllers;


use app\services\ParserService;
use app\services\ReportService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class ParserController
 *
 * @package app\controllers
 */
class ParserController extends Controller
{

    /**
     * @var \app\services\ParserService
     */
    private ParserService $parserService;

    /**
     * @var \app\services\ReportService
     */
    private ReportService $reportService;

    /**
     * ParserController constructor.
     *
     * @param $id
     * @param $module
     * @param \app\services\ParserService $parserService
     * @param \app\services\ReportService $reportService
     */
    public function __construct(
        $id,
        $module,
        ParserService $parserService,
        ReportService $reportService
    )
    {
        parent::__construct($id, $module);
        $this->parserService = $parserService;
        $this->reportService = $reportService;

    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Парсер ссылок по магазину
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \yii\base\ErrorException
     */
    public function actionIndex($id = 0): Response
    {

        $this->parserService->process($id);

        Yii::$app->session->setFlash('success', 'Завершено.');
        return $this->redirect(['/site/index', 'id' => $id]);

    }

    /**
     * @param $ids
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDownload($ids): void
    {

        $this->reportService->export($ids);

    }

    /**
     * Очистка каталога кеша
     *
     */
    public function actionCleanCache(): void
    {
        exec('rm -rf ' . Yii::getAlias('@webroot') . '/uploads/cache/*');

        $path = Yii::getAlias('@webroot') . '/uploads/cache/';
        $files = glob($path);
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }

        Yii::$app->session->setFlash('success', 'Кэш успешно очищен');
        $this->redirect('/');
    }

}
