<?php

/** @var \app\processing\Elektrik $Elektrik */
/** @var $this yii\web\View */

$this->title = 'Game Elektrik';
?>

<h1><?=$this->title ?> <a href="https://github.com/lkg0dzre/DEMO__Yii2__Elektrik-Game" target="_blank">GitHub</a></h1>

<div class="b-buttons">
    <div class="b-button js-button--new-game">New game</div>
    <div class="b-button js-button--best">Leaderboard</div>
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
            Your score: <span class="js-step-count"></span>
        </div>


        <div class="b-popup js-winner">
            <div class="b-popup__close js-popup__close" data-new-game="true">&times;</div>

            <form class="b-winner-form js-winner-form" action="/">
                <h2 class="b-winner-form__header">WIN!</h2>
                <h3 class="b-winner-form__header">Your score: <span class="b-winner-form__step_count js-winner__step-count"></span></h3>
                <br>
                Name: <br>
                <input class="b-winner-form__input" type="text" name="name" value="<?= $Elektrik->getName() ?>">
                <button type="submit" class="b-button">Send</button>
            </form>
        </div>


        <div class="b-popup js-leaderboard">
            <div class="b-popup__close js-popup__close">&times;</div>

            <h2 class="b-popup__header">Leaderboard</h2>
            <table class="b-leaderboard js-leaderboard-table"></table>
        </div>

    </div>
</div>



<?php

$click = <<<JS
    $(document).ready(function() {
        
        
        loadMap();
        
        
        let jHtml = $('html');
        
        jHtml.on('click', '.js-cell', function(event) {
            event.preventDefault();
            
            var row = $(this).data('row');
            var column = $(this).data('column');
            
            $.ajax({
                url: '/elektrik/ajax-click-cell',
                method: 'POST',
                data: {
                    row: row,
                    column: column
                }    
            }).done(function(game_data) {
                updateGame(game_data);
            });

        });
        
         jHtml.on('click', '.js-button--new-game', function(event) {
            event.preventDefault();
            
            newGame();
        });
         
         jHtml.on('click', '.js-button--best', function(event) {
             event.preventDefault();
             
             $.ajax({
                 url: '/elektrik/ajax-leaderboard',
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
         
         jHtml.on('click', '.js-popup__close', function(event) {
             event.preventDefault();
             
             if ($(this).data('new-game') == true) {
                newGame();
             }
             
             $(this).parent().hide();
         });
         
         jHtml.on('submit', '.js-winner-form', function(event) {
             event.preventDefault();
             
             var that = this;
             
             $.ajax({
                 url: '/elektrik/ajax-save-winner',
                 method: 'POST',
                 data: $(this).serialize()    
             }).done(function() {
                 $(that).parent().hide();
                 newGame();
             });
         });
        
        
        /*** FUNCTiONS ***/
        
        function loadMap() {
            $.ajax({
                url: '/elektrik/ajax-load-map',
                method: 'POST',
                data: {}    
            }).done(function(game_data) {
                updateGame(game_data);
            });
        }
        
        function newGame() {
            $.ajax({
                url: '/elektrik/ajax-new-game',
                method: 'POST',
            }).done(function(game_data) {
                updateGame(game_data);
            });
        }

        function updateGame(game_data) {
            updateGamefield(game_data['map']);
            updateStepCount(game_data['step_count']);
                checkForWin(game_data);
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
        
        function checkForWin(game_data) {
            if (game_data['win']) {
                $('.js-winner__step-count').text(game_data['step_count']);
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