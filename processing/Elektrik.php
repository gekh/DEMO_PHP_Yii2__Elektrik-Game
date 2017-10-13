<?php

namespace app\processing;

use yii\base\Component;
use yii\helpers\VarDumper;

class Elektrik extends Component
{

    protected $map = [];
    protected $win = false;
    protected $step_count = 0;

    public function __construct(array $config = [])
    {
        $this->reset();

        parent::__construct($config);
    }

    public function getMap() { return $this->map; }
    public function  isWin() { return $this->win; }

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

    public function dump()
    {
        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                echo $this->map[$row][$column] . ' ';
            }
            echo '<br>';
        }
    }

    public function play($play_row, $play_column)
    {

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

        $this->checkForWin();
    }

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
    }

}