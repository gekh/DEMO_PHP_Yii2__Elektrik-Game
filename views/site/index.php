<?php

/* @var $this yii\web\View */

$this->title = 'Игра «Електрик»';
?>

<style>

    .b-gamefield {
        width         : 500px;
        height        : 500px;
        background    : black;
        border        : 3px solid gold;
        border-radius : 20px;
        margin        : auto;
        padding       : 20px;
    }

    .b-cell {
        display          : inline-block;
        width            : 80px;
        height           : 80px;
        margin           : 5px;
        background-color : gold;
        vertical-align   : bottom;

    }
</style>

<div class="site-index">

    <div class="body-content">

        <div class="b-gamefield"><!--

            <?php for($row=1; $row <= 5; $row++): ?>
                <?php for($column=1; $column <= 5; $column++): ?>
                    --><div class="b-cell"></div><!--
                <?php endfor ?>
            <?php endfor ?>

        --></div>

    </div>
</div>
