<?php

namespace app\models;

use app\components\AclHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contact;

/**
 * ContactSearch represents the model behind the search form about `app\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id'], 'integer'],
            [['name', 'surname', 'phone', 'address', 'username'], 'safe'],
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
        $query = Contact::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$query->select('contact.*,u.username');
		
		$query->leftJoin('user u', 'u.id = author_id');
		
		if(Yii::$app->authManager->getAssignment(AclHelper::ROLE_ADMIN, \Yii::$app->user->id) === null) {
			$query->where(['author_id' => Yii::$app->get('user', false)->id]);
//			$params['ContactSearch']['user_id'] = Yii::$app->get('user', false)->id;	
		}
		
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
			'id'		 => $this->id,
//			'user_id'	 => Yii::$app->get('user', false)->id,
			'created'	 => $this->created,
			'updated'	 => $this->updated,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address]);
		
        return $dataProvider;
    }
}
