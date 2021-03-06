<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projects;

/**
 * ProjectsSearch represents the model behind the search form about `app\models\Projects`.
 */
class ProjectsSearch extends Projects
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['project_name', 'client_name', 'project_description', 'project_owner_id', 'project_type_id', 'project_technology_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Projects::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('projectTechnology');
        $query->joinWith('projectType');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'project_owner_id' => Yii::$app->user->getId()
        ]);

        $query->andFilterWhere(['like', 'project_name', $this->project_name])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'project_description', $this->project_description])
            ->andFilterWhere(['like', 'technologies.technology_name', $this->project_technology_id])
            ->andFilterWhere(['like', 'project_type.type_name', $this->project_type_id]);

        return $dataProvider;
    }
}
