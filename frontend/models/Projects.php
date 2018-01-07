<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $project_name
 * @property integer $project_owner_id
 * @property string $client_name
 * @property string $project_description
 * @property integer $project_type_id
 * @property integer $project_technology_id
 *
 * @property ProjectType $projectType
 * @property Technologies $projectTechnology
 * @property User $projectOwner
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_name', 'project_owner_id', 'client_name', 'project_type_id'], 'required'],
            [['project_owner_id', 'project_type_id', 'project_technology_id'], 'integer'],
            [['project_name', 'client_name', 'project_description'], 'string', 'max' => 255],
            [['project_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectType::className(), 'targetAttribute' => ['project_type_id' => 'id']],
            [['project_technology_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technologies::className(), 'targetAttribute' => ['project_technology_id' => 'id']],
            [['project_owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['project_owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_name' => 'Project Name',
            'project_owner_id' => 'Project Owner',
            'client_name' => 'Client Name',
            'project_description' => 'Project Description',
            'project_type_id' => 'Project Type',
            'project_technology_id' => 'Project Technology',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectType()
    {
        return $this->hasOne(ProjectType::className(), ['id' => 'project_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTechnology()
    {
        return $this->hasOne(Technologies::className(), ['id' => 'project_technology_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'project_owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectFiles()
    {
        return $this->hasMany(Files::className(), ['project_id' => 'id']);
    }

}
