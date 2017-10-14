<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leaderboard".
 *
 * @property integer $id
 * @property string $name
 * @property integer $step_count
 * @property string $created_at
 */
class Leaderboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leaderboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['step_count'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'step_count' => 'Step Count',
            'created_at' => 'Created At',
        ];
    }
}