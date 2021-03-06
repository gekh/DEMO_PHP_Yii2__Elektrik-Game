<?php

namespace app\processing;

use app\models\Leaderboard;
use yii\base\Component;
use yii\db\Query;

class Elektrik extends Component
{
    protected $map = [];
    protected $win = false;
    protected $step_count = 0;
    protected $name = '';

    public function __construct(array $config = [])
    {
        $this->reset();
        parent::__construct($config);
    }

    public function getMap() { return $this->map; }
    public function  isWin() { return $this->win; }
    public function getStepCount() { return $this->step_count; }
    public function getName() { return $this->name; }


    /**
     * @return array 10 scores with the best results
     */
    public function getLeaderboard()
    {
        return (new Query())
            ->select(['name', 'step_count'])
            ->from('leaderboard')
            ->orderBy([
                'step_count' => SORT_ASC,
                'created_at' => SORT_DESC,
            ])
            ->limit(10)
            ->all();
    }

    /**
     * Resets all buttons to zero state
     */
    public function reset()
    {
        $this->win = false;
        $this->step_count = 0;
        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                $this->map[$row][$column] = 0;
            }
        }
    }

    /**
     * Turns on random buttons on the map
     */
    public function randomMap()
    {
        do {
            $this->reset();

            for ($row = 1; $row <= 5; $row++) {
                for ($column = 1; $column <= 5; $column++) {
                    if (mt_rand(1, 2) == 2) {
                        $this->map[$row][$column] = 1;
                    }
                }
            }

            $count = $this->checkForWin();
        } while ($count > 20);
    }

    /**
     * DEV only!
     * Prints current map state
     */
    public function dump()
    {
        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                echo $this->map[$row][$column] . ' ';
            }
            echo '<br>';
        }
    }

    /**
     * Processes each movement in the game
     * @param $play_row
     * @param $play_column
     */
    public function play($play_row, $play_column)
    {
        $this->step_count++;

        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                $is_in_row_range = (in_array($row, [$play_row-1, $play_row, $play_row+1]));
                $is_in_column_range = (in_array($column, [$play_column-1, $play_column, $play_column+1]));

                if ($row == $play_row and $column == $play_column) {
                    $this->map[$row][$column] = 1;
                } else if ($is_in_row_range and $is_in_column_range) {
                    $this->map[$row][$column] = 1 - $this->map[$row][$column];
                }
            }
        }

        $this->misfortune($play_row, $play_column);

        $this->checkForWin();
    }

    /**
     * Saves result to Leaderboard in database
     * @param $name Player's name
     */
    public function saveWinner($name)
    {
        if (empty($name)) {
            return;
        }

        if (!$this->isWin()) {
            return;
        }

        $Leaderboard = new Leaderboard();
        $Leaderboard->name = $name;
        $Leaderboard->step_count = $this->step_count;
        $Leaderboard->save();

        $this->name = $name;
    }



    /**********************/
    /*** PROTECTED ZONE ***/
    /**********************/

    /** Randomly turns off one button with a small chance */
    protected function misfortune($play_row, $play_column)
    {
        if (mt_rand(1, 25) == 25) {
            do {
                $rand_row    = mt_rand(1, 5);
                $rand_column = mt_rand(1, 5);
            } while (
                $rand_row != $play_row
                and $rand_column != $play_column
                and $this->map[$rand_row][$rand_column] == 0);

            $this->map[$rand_row][$rand_column] = 0;
        }
    }

    /**
     * @return int Returns current count of enabled buttons
     */
    protected function checkForWin()
    {
        $count = 0;

        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                if ($this->map[$row][$column] == 1) {
                    $count++;
                }
            }
        }

        if ($count == 25) {
            $this->win = true;
        }

        return $count;
    }

}