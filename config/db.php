<?php

$_fn = realpath(__DIR__."/../data")."/sqlite_data.db";

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . $_fn,
];