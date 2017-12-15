<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "technologies".
 *
 * @property integer $id
 * @property string $technology_name
 *
 * @property Projects[] $projects
 */
class Technologies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technologies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['technology_name'], 'required'],
            [['technology_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'technology_name' => 'Technology Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::className(), ['project_technology_id' => 'id']);
    }
}
