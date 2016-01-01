<?php

namespace app\controllers;

use app\components\AclHelper;
use Yii;
use app\models\Contact;
use app\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller {

	public function behaviors() {
		return [
			'verbs'	 => [
				'class'		 => VerbFilter::className(),
				'actions'	 => [
					'delete' => ['post'],
				],
			],
			'access' => [
				'class'	 => AccessControl::className(),
//                'only' => ['login', 'logout', 'signup', 'index'],
				'rules'	 => [
					[
						'allow'		 => true,
						'actions'	 => ['login', 'signup'],
						'roles'		 => ['?'],
					],
					[
						'allow'		 => true,
						'actions'	 => ['logout'],
						'roles'		 => ['@'],
					],
					[
						'allow'	 => true,
//                        'actions' => ['*'],
						'roles'	 => ['@'],
					],
				],
			],
		];
	}

	/**
	 * Lists all Contact models.
	 * @return mixed
	 */
	public function actionIndex() {

		$searchModel	 = new ContactSearch();
		$dataProvider	 = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(['pageSize' => 10]);

		return $this->render('index', [
					'searchModel'	 => $searchModel,
					'dataProvider'	 => $dataProvider,
		]);
	}

	/**
	 * Displays a single Contact model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		$model = $this->findModel($id);

		if (!\Yii::$app->user->can(AclHelper::PERMISSION_VIEW_POST, ['post' => $model])) {
			throw new NotFoundHttpException('You havent access to view this item.');
		}

		return $this->render('view', [
					'model' => $model,
		]);
	}

	/**
	 * Creates a new Contact model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Contact();

		if (!\Yii::$app->user->can('createPost', ['post' => $model])) {
			throw new NotFoundHttpException('You havent access to create item.');
		}

		$model->setScenario(Contact::SCENARIO_ADD_CONTACT);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
						'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Contact model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if (!\Yii::$app->user->can('updatePost', ['post' => $model])) {
			throw new NotFoundHttpException('You havent access to edit this item.');
		}

		$model->setScenario(Contact::SCENARIO_ADD_CONTACT);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
						'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Contact model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
	public function actionDelete($id) {
		$model = $this->findModel($id);

		if (!\Yii::$app->user->can('deletePost', ['post' => $model])) {
			throw new NotFoundHttpException('You havent access to delete this item.');
		}
		$model->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Contact model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Contact the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if ($model = Contact::findOne($id)) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}
