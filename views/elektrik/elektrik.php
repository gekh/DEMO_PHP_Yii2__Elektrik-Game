<?php

/* @var $this yii\web\View */

$this->title = 'Игра «Електрик»';
?>

<h1><?=$this->title ?></h1>

<div class="b-buttons">
    <div class="b-button js-button--new-game">Новая игра</div>
    <div class="b-button js-button--best">Лучшие результаты</div>
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

        <div class="b-ste-counter">
            Сделано ходов: <span class="js-step-count"></span>
        </div>


        <div class="b-popup js-winner">
            <div class="b-popup__close js-popup__close">&times;</div>

            <form class="b-winner-form js-winner-form" action="/">
                <h2 class="b-winner-form__header">Вы победили!</h2>
                <br>
                <input type="text" name="name" placeholder="Ваше имя">
                <button type="submit" class="b-button">Отправить</button>
            </form>
        </div>

        <div class="b-popup js-leaderboard">
            <div class="b-popup__close js-popup__close">&times;</div>

            <h2 class="b-popup__header">Лучшие результаты</h2>
            <table class="b-leaderboard js-leaderboard-table"></table>
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
                updateGame(game_data);
            });

        });
        
         $('body').on('click', '.js-button--new-game', function(event) {
            event.preventDefault();
            
            resetField();
        });
         
         $('body').on('click', '.js-button--best', function(event) {
             event.preventDefault();
             
             $.ajax({
                 url: '/elektrik/a-j-a-x-leaderboard',
                 method: 'POST',
             }).done(function(leaderboard) {
                $('.js-leaderboard-table').html('');
                
                var l = leaderboard.length;
                for (var i=0; i < l; i++) {
                    var name = leaderboard[i]['name'];
                    var step_count = leaderboard[i]['step_count'];
                    $('.js-leaderboard-table').append('<tr><td>' + (i+1) + '.</td><td>' + name + '</td><td>' + step_count + '</td></tr>');
                }
             });
             
             $('.js-leaderboard').show();
         });
         
         $('body').on('click', '.js-popup__close', function(event) {
             event.preventDefault();
             
             resetField();
             $(this).parent().hide();
         });
         
         $('body').on('submit', '.js-winner-form', function(event) {
             event.preventDefault();
             
             var that = this;
             
             $.ajax({
                 url: '/elektrik/a-j-a-x-save-winner',
                 method: 'POST',
                 data: $(this).serialize()    
             }).done(function() {
                 $(that).parent().hide();
                 resetField();
             });
         });
        
        
        /*** FUNCTiONS ***/
        
        function loadMap() {
            $.ajax({
                url: '/elektrik/a-j-a-x-load-map',
                method: 'POST',
                data: {}    
            }).done(function(game_data) {
                updateGame(game_data);
            });
        }
        
        function resetField() {
            $.ajax({
                url: '/elektrik/a-j-a-x-new-game',
                method: 'POST',
            }).done(function(game_data) {
                updateGame(game_data);
            });
        }

        function updateGame(game_data) {
            updateGamefield(game_data['map']);
            updateStepCount(game_data['step_count']);
                checkForWin(game_data['win']);
        }
        
        function updateGamefield(map) {
            for (var row = 1; row <= 5; row++) {
                for (var column = 1; column <= 5; column++) {
                    var id = 'cell-' + row + column;
                    var element = document.getElementById(id);
                    
                    if (map[row][column] == 1) { 
                        on(element);
                    } else {
                        off(element);
                    }
                }
            }
        }
        
        function updateStepCount(step_count) {
            $('.js-step-count').text(step_count);
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