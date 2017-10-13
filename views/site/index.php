<?php

/* @var $this yii\web\View */

$this->title = 'Игра «Електрик»';
?>

<style>

    h1 {
        font-family : "Courier New", sans-serif;
        color       : white;
        text-align  : center;
        margin      : 50px;
    }

    .b-gamefield {
        width         : 500px;
        height        : 500px;
        background    : black;
        border        : 3px solid #009688;
        border-radius : 20px;
        margin        : auto;
        padding       : 20px;
    }

    .b-cell-wrap {
        display          : inline-block;
        width            : 80px;
        height           : 80px;
        margin           : 5px;
        text-align       : center;
        vertical-align   : bottom;
        background-color : #009688;
        padding          : 10px;
        border-radius    : 100%;
        box-shadow       : inset 0px 0px 10px rgba(0, 0, 0, 0.5);

    }

    .b-cell {
        width              : 60px;
        height             : 60px;
        border-radius      : 100%;
        margin             : auto;
        cursor             : pointer;
        opacity            : 0;

        -webkit-transition : opacity .2s linear;
        -moz-transition    : opacity .2s linear;
        -o-transition      : opacity .2s linear;
        transition         : opacity .2s linear;
    }

    .b-cell--lit {
        opacity: 1;

        box-shadow : 0 0 20px yellow;

        background : #f8ffe8; /* Old browsers */
        background : -moz-linear-gradient(135deg, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* FF3.6-15 */
        background : -webkit-linear-gradient(135deg, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* Chrome10-25,Safari5.1-6 */
        background : linear-gradient(135deg, #f8ffe8 0%, #e3f5ab 33%, #b7df2d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter     : progid:DXImageTransform.Microsoft.gradient(startColorstr='#f8ffe8', endColorstr='#b7df2d', GradientType=0); /* IE6-9 */

        background-size: 400% 400%;

        -webkit-animation: AnimationName 2s ease infinite;
        -moz-animation: AnimationName 2s ease infinite;
        animation: AnimationName 2s ease infinite;
    }

    .b-cell--hide {
        opacity: 0;
    }



    /*** Анимация ***/

    @-webkit-keyframes AnimationName {
        0%{background-position:0% 51%}
        50%{background-position:100% 50%}
        100%{background-position:0% 51%}
    }
    @-moz-keyframes AnimationName {
        0%{background-position:0% 51%}
        50%{background-position:100% 50%}
        100%{background-position:0% 51%}
    }
    @keyframes AnimationName {
        0%{background-position:0% 51%}
        50%{background-position:100% 50%}
        100%{background-position:0% 51%}
    }

</style>

<h1><?=$this->title ?></h1>

<div class="site-index">

    <div class="body-content">

        <div class="b-gamefield"><!--

            <?php for($row=1; $row <= 5; $row++): ?>
                <?php for($column=1; $column <= 5; $column++): ?>

                    <?php $light_class = ($row > 3 and $column >= 3) ? "b-cell--lit" : "" ?>

                    --><div class="b-cell-wrap"><div class="b-cell js-cell <?=$light_class ?>"></div></div><!--

                <?php endfor ?>
            <?php endfor ?>

        --></div>

    </div>
</div>

<?php

$script = <<<JS
    $(document).ready(function() {
        $('body').on('click', '.js-cell', function(event) {
            // event.preventDefault();

            toggleCell(this);
        });

        function toggleCell(element) {
            if ($(element).hasClass('b-cell--lit')) {
                hideCell(element);    
            } else {
                showCell(element);
            }
        }
        
        function showCell(element) {
            element.classList.add('b-cell--lit');
            setTimeout(function(){element.classList.remove('b-cell--hide');}, 210);
        }
        
        function hideCell(element) {
            element.classList.add('b-cell--hide');
            setTimeout(function(){element.classList.remove('b-cell--lit');}, 210);
        }
    });
JS;


$this->registerJs($script);

?>