<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\processing\Elektrik;
use yii\web\Response;

/**
 * Controller for all http queries
 * @property \app\processing\Elektrik $elektrik
 */
class ElektrikController extends Controller
{
    public $defaultAction = 'elektrik';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Main page
     */
    public function actionElektrik()
    {
        $Elektrik = $this->getElektrik();
        return $this->render('elektrik', compact('Elektrik'));
    }

    /**
     * Handles clicks on buttons
     */
    public function actionAjaxClickCell()
    {
        $Elektrik = $this->getElektrik();

        $row = (int)$_POST['row'];
        $column = (int)$_POST['column'];

        $Elektrik->play($row, $column);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->gameData();
    }

    public function actionAjaxLoadMap()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->gameData();
    }

    public function actionAjaxNewGame()
    {
        $Elektrik = $this->getElektrik();
        $Elektrik->randomMap();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->gameData();
    }

    /**
     * Saves the form with the winner name, when the game is successfully finished
     */
    public function actionAjaxSaveWinner()
    {
        $Elektrik = $this->getElektrik();
        $name = (string)$_POST['name'];
        $Elektrik->saveWinner($name);
    }

    /**
     * Load leaderboard data
     */
    public function actionAjaxLeaderboard()
    {
        $Elektrik = $this->getElektrik();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $Elektrik->getLeaderboard();
    }


    /**
     * @return Elektrik Object with all game data and processing methods
     */
    protected function getElektrik()
    {
        $Elektrik = Yii::$app->session->get('Elektrik');

        if (!$Elektrik) {
            $Elektrik = new Elektrik();
            Yii::$app->session->set('Elektrik', $Elektrik);
        }

        return $Elektrik;
    }

    /**
     * @return array Main data about the game
     */
    protected function gameData()
    {
        $Elektrik = $this->getElektrik();

        return [
            'win' => $Elektrik->isWin(),
            'map' => $Elektrik->getMap(),
            'step_count' => $Elektrik->getStepCount(),
        ];
    }

}
