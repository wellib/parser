<?php

namespace app\commands;

use app\services\ParserService;
use yii\console\Controller;
use yii\console\ExitCode;

class ParserController extends Controller
{

    /**
     * @var \app\services\ParserService
     */
    private ParserService $parserService;

    /**
     * ParserController constructor.
     *
     * @param $id
     * @param $module
     * @param \app\services\ParserService $parserService
     */
    public function __construct(
        $id,
        $module,
        ParserService $parserService
    )
    {
        parent::__construct($id, $module);
        $this->parserService = $parserService;
    }

    /**
     * @param int $storeId
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \yii\base\ErrorException
     */
    public function actionIndex(int $storeId = 0): int
    {

        $this->parserService->process($storeId);

        return ExitCode::OK;
    }
}
