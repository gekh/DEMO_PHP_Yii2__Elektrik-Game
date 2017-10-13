<?php

namespace app\processing;

use yii\base\Component;
use yii\helpers\VarDumper;

class Elektrik extends Component
{

    protected $map = [];

    public function __construct(array $config = [])
    {
        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                $this->map[$row][$column] = 0;
            }
        }

        parent::__construct($config);
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

    public function play($row, $column)
    {
        for ($row = 1; $row <= 5; $row++) {
            for ($column = 1; $column <= 5; $column++) {
                $is_in_row_range = (in_array($row, [$row-1, $row, $row+1]));
                $is_in_column_range = (in_array($column, [$column-1, $column, $column+1]));

                if ($is_in_row_range and $is_in_column_range) {
                    $this->map[$row][$column] = 1;
                }
            }
        }
    }

    public function getMap()
    {
        return $this->map;
    }

}