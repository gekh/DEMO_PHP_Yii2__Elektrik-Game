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
        border-radius: 100%;

    }

    .b-cell--lit {
        box-shadow: 0 0 20px yellow;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f8ffe8+0,e3f5ab+33,b7df2d+100;Green+3D+%234 */
        background: #f8ffe8; /* Old browsers */
        background: -moz-linear-gradient(top, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f8ffe8 0%,#e3f5ab 33%,#b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8ffe8', endColorstr='#b7df2d',GradientType=0 ); /* IE6-9 */
    }






    }
</style>

<div class="site-index">

    <div class="body-content">

        <div class="b-gamefield"><!--

            <?php for($row=1; $row <= 5; $row++): ?>
                <?php for($column=1; $column <= 5; $column++): ?>

                    <?php $light_class = ($row > 4 and $column == 3) ? "b-cell--lit" : "" ?>

                    --><div class="b-cell <?=$light_class ?>"></div><!--

                <?php endfor ?>
            <?php endfor ?>

        --></div>

    </div>
</div>
