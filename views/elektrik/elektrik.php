<?php

/* @var $this yii\web\View */

$this->title = 'Игра «Електрик»';
?>

<h1><?=$this->title ?></h1>

<div class="b-buttons">
    <div class="b-button js-button--new-game">Новая игра</div>
</div>

<div class="site-index">

    <div class="body-content">

        <div class="b-gamefield"><!--

            <?php for($row=1; $row <= 5; $row++): ?>
                <?php for($column=1; $column <= 5; $column++): ?>

             --><div class="b-cell-wrap">
                    <div class="b-cell js-cell" id="cell-<?=$row . $column ?>" data-row="<?=$row ?>"
                         data-column="<?= $column ?>"></div>
                </div><!--

                <?php endfor ?>
            <?php endfor ?>

        --></div>


        <div class="b-winner js-winner">
            <div class="b-winner__close js-winner__close">&times;</div>
            <form class="b-winner-form" action="/">
                <h2 class="b-winner-form__header">Вы победили!</h2>
                <br>
                <input type="text" placeholder="Ваше имя">
                <button type="submit" class="b-button">Отправить</button>
            </form>
        </div>

    </div>
</div>



<?php

$click = <<<JS
    $(document).ready(function() {
        
        
        loadMap();
        
        
        $('body').on('click', '.js-cell', function(event) {
            event.preventDefault();
            
            var row = $(this).data('row');
            var column = $(this).data('column');
            
            $.ajax({
                url: '/elektrik/a-j-a-x-click-cell',
                method: 'POST',
                data: {
                    row: row,
                    column: column
                }    
            }).done(function(game_data) {
                updateGamefield(game_data['map']);
                checkForWin(game_data['win']);
            });

        });
        
         $('body').on('click', '.js-button--new-game', function(event) {
            event.preventDefault();
            
            resetField();
        });
         
         $('body').on('click', '.js-winner__close', function(event) {
             event.preventDefault();
             
             resetField();
             $(this).parent().hide();
         });
        
        
        /*** FUNCTiONS ***/
        
        function loadMap() {
            $.ajax({
                url: '/elektrik/a-j-a-x-load-map',
                method: 'POST',
                data: {}    
            }).done(function(game_data) {
                updateGamefield(game_data['map']);
                checkForWin(game_data['win']);
            });
        }
        
        function resetField() {
            $.ajax({
                url: '/elektrik/a-j-a-x-new-game',
                method: 'POST',
            }).done(function(game_data) {
                updateGamefield(game_data['map']);
                checkForWin(game_data['win']);
            });
        }

        
        function updateGamefield(map) {
            for (var row = 1; row <= 5; row++) {
                for (var column = 1; column <= 5; column++) {
                    var id = 'cell-' + row + column;
                    var element = document.getElementById(id);
                    
                    if (map[row][column]==1) { 
                        on(element);
                    } else {
                        off(element);
                    }
                }
            }
        }
        
        function checkForWin(is_win) {
            if (is_win) {
                $('.js-winner').show();
            }
        }
       
        function on(element) {
            if ( ! $(element).hasClass('b-cell--lit')) {
                element.classList.add('b-cell--lit');
                setTimeout(function(){element.classList.remove('b-cell--hide');}, 210);
            }
        }
        
        function off(element) {
            element.classList.add('b-cell--hide');
            setTimeout(function(){element.classList.remove('b-cell--lit');}, 210);
        }
        
        
    });
JS;


$this->registerJs($click);

?>