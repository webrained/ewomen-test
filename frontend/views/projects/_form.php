<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Technologies;
use app\models\ProjectType;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_type_id')->dropDownList(
        ArrayHelper::map(ProjectType::find()->all(),'id','type_name'),
        ['prompt' => 'Select Type']
    ) ?>

    <?= $form->field($model, 'project_technology_id')->dropDownList(
            ArrayHelper::map(Technologies::find()->all(),'id','technology_name'),
            ['prompt' => 'Select Technology']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
