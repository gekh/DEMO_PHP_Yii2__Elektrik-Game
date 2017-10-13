<?php

/* @var $this yii\web\View */

$this->title = 'Игра «Електрик»';
?>

<h1><?=$this->title ?></h1>

<div class="site-index">

    <div class="body-content">

        <div class="b-gamefield"><!--

            <?php for($row=1; $row <= 5; $row++): ?>
                <?php for($column=1; $column <= 5; $column++): ?>

                    --><div class="b-cell-wrap"><div class="b-cell js-cell"></div></div><!--

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