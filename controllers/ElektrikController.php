<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\processing\Elektrik;

class ElektrikController extends Controller
{

    public $defaultAction = 'elektrik';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionElektrik()
    {
        return $this->render('elektrik');
    }

    public function actionAJAXClickCell()
    {
        $elektrik = $this->getElektrik();

        $row = intval($_POST['row']);
        $column = intval($_POST['column']);

        $elektrik->play($row, $column);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->gameData();
    }

    public function actionAJAXLoadMap()
    {
        $elektrik = $this->getElektrik();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->gameData();
    }

    public function actionAJAXNewGame()
    {
        $elektrik = $this->getElektrik();
        $elektrik->reset();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->gameData();
    }

    public function getElektrik()
    {
        $elektrik = \Yii::$app->session->get('elektrik');

        if (!$elektrik) {
            $elektrik = new Elektrik();
            \Yii::$app->session->set('elektrik', $elektrik);
        }

        return $elektrik;
    }

    public function gameData()
    {
        $elektrik = $this->getElektrik();

        return [
            'win' => $elektrik->isWin(),
            'map' => $elektrik->getMap(),
            'step_count' => $elektrik->getStepCount(),
        ];
    }

}
