<?php

namespace frontend\controllers;

use app\models\Files;
use Yii;
use app\models\Projects;
use app\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $file_model = new Files();
        $model = $this->findModel($id);
        $project_files = $model->projectFiles;
        $success = 0;

        if (Yii::$app->request->isAjax) {
            $file_model->load(Yii::$app->request->post());
            $file_model->image = UploadedFile::getInstance($file_model, 'image');
            $file_model->title = $file_model->image->name;
            $file_model->file_name = md5(date("Y-m-d H:i:s")) . '.' . $file_model->image->extension;
            $file_model->project_id = $id;
            if ($file_model->upload()) {
                $file_model->save();
                Yii::$app->getSession()->addFlash('success', 'Image uploaded');
                $success = 1;
                return $success;
            }
        }


        return $this->render('view', [
            'model' => $model,
            'file_model' => $file_model,
            'project_files' => $project_files,
        ]);
    }

    public function actionDeleteFile() {
        if(Yii::$app->request->isAjax) {
            $success = false;

            $data = Yii::$app->request->post();
            $FileModel =  Files::findOne($data['id']);
            $file_path = 'uploads/'. $FileModel->project_id . '/' . $FileModel->file_name;


            if($FileModel && file_exists($file_path)) {
                if (@unlink($file_path) && $FileModel->delete()) {
                    Yii::$app->getSession()->addFlash('succes','File has been deleted successfully');
                    $success = true;
                } else {
                    Yii::$app->getSession()->addFlash('error','Sorry, could not delete the file');
                }
            } else {
                Yii::$app->getSession()->addFlash('error','Sorry, there is no such file');
            }

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $success;
            $response->statusCode = 200;
            return $response;
        }
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Projects();
        $model->project_owner_id = Yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
