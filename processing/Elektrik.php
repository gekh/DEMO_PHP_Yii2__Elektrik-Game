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

}