<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $file_name
 *
 * @property Projects $project
 */
class Files extends \yii\db\ActiveRecord
{

    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'file_name'], 'required'],
            [['project_id'], 'integer'],
            [['file_name'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 200],
            [['image'], 'file'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'file_name' => 'File Name',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['project_id' => 'id']);
    }

    public function upload()
    {
        $uploadPath = 'uploads/' . $this->project_id;

        if ($this->validate()) {
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath);
                chmod($uploadPath , 0777);
            }
            $this->image->saveAs($uploadPath . '/' . $this->file_name);
            chmod($uploadPath . '/' . $this->file_name,0777);
            return true;
        }
        else {
            return false;
        }
    }
}
