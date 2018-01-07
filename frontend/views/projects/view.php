<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Projects */


$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->project_name;
?>
<div class="projects-view">
    <div class="row">
        <h1 class="pull-left" style="margin: 0;"><?= $model->project_name . ' - ' . $model->client_name ?></h1>
        <p class="pull-right">
            <span class="project-type"><?= $model->projectType->type_name; ?></span>
            <span class="technology-type"><?= $model->projectTechnology->technology_name; ?></span>
            <?= Html::a('', ['update', 'id' => $model->id], ['class' => 'btn glyphicon glyphicon-pencil']) ?>
            <?= Html::a('', ['delete', 'id' => $model->id], [
                'class' => 'btn glyphicon glyphicon-trash red',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>


    <h2>
        <?= $model->project_description; ?>
    </h2>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'hide-detailView'
        ],
        'attributes' => [
            'project_name',
            'client_name',
            'project_description',
            'project_type_id',
            'project_technology_id',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'view-form']]) ?>
    <?= $form->field($file_model, 'image')->fileInput()->label(false) ?>
    <?php foreach ($project_files as $project_file) { ?>
    <div class="file_wrapper">
        <a class="files" href="../uploads/<?= $model->id ?>/<?= $project_file->file_name ?>" title="<?= $project_file->title; ?>" download><i class="glyphicon glyphicon-download" style="margin-left: 2px;"></i></a>
        <i class="glyphicon glyphicon-remove remove" data-id="<?= $project_file->id; ?>"></i>
    </div>
    <?php } ?>
    <label for="files-image"><i class="glyphicon glyphicon-plus"></i></label>
    <input type="submit" class="btn btn-success subm" value="Upload">
    <?php ActiveForm::end(); ?>
</div>


<script type="text/javascript">
    $('.subm').click(function (e) {
        var formData = new FormData($('#w1')[0]);
        $.ajax({
            url: '<?= Url::to(['projects/view', 'id' => $model->id]) ?>',  //Server script to process data
            data: formData,
            type: 'POST',
            dataType: 'json',

            cache: false,
            contentType: false,
            processData: false
        }).done(function (response) {
            alert('Your Project file was uploaded successfully');
        }).fail(function (response) {
            alert('error');
        });
    });

    $('.remove').click(function () {
        var id = $(this).attr('data-id');
        var el = $(this).parent(".file_wrapper");
        console.log(id);
        $.ajax({
            url: '<?= Url::to(['projects/delete-file']) ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'json'

        }).done(function(res) {
            el.css("display","none");
            console.log($(this).parent(".file_wrapper"));
        });
    });
</script>
