<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\processing\Elektrik;

class ElektrikController extends Controller
{

    public $defaultAction = 'elektrik';

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

    public function actionAJAXSaveWinner()
    {
        $elektrik = $this->getElektrik();
        $name = strval($_POST['name']);
        $elektrik->saveWinner($name);
    }

    public function actionAJAXLoadWinners()
    {
        $elektrik = $this->getElektrik();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $elektrik->getBest();
    }



    protected function getElektrik()
    {
        $elektrik = \Yii::$app->session->get('elektrik');

        if (!$elektrik) {
            $elektrik = new Elektrik();
            \Yii::$app->session->set('elektrik', $elektrik);
        }

        return $elektrik;
    }

    protected function gameData()
    {
        $elektrik = $this->getElektrik();

        return [
            'win' => $elektrik->isWin(),
            'map' => $elektrik->getMap(),
            'step_count' => $elektrik->getStepCount(),
        ];
    }

}
