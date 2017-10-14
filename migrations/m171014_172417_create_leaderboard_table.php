<?php

use yii\db\Migration;

/**
 * Handles the creation of table `leaderboard`.
 */
class m171014_172417_create_leaderboard_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('leaderboard', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'step_count' => $this->integer(),
            'created_at' => $this->datetime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('leaderboard');
    }
}
