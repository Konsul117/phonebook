<?php

namespace app\controllers;

use app\components\AjaxResponse;
use app\models\FiasAddrobj;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AddressController extends Controller {

	/**
	 * @var AjaxResponse
	 */
	protected $ajaxResponse;

	public function init() {
		parent::init();
		$this->ajaxResponse = new AjaxResponse();
	}

	public function afterAction($action, $result) {
		parent::afterAction($action, $result);
		if (Yii::$app->response->format == Response::FORMAT_JSON) {
			header('Content-Type: application/json');

			return $this->ajaxResponse;
		}

		return null;
	}

	public function actionCities() {
		//@TODO: добавить проверку результата запроса и указание result, error у responce
		$query = Yii::$app->request->post('query');
		Yii::$app->response->format = Response::FORMAT_JSON;
		$citiesCommand = FiasAddrobj::find()
			->select([FiasAddrobj::tableName() . '.aoguid AS id', FiasAddrobj::tableName() . '.formalname AS title'])
			->where([
					FiasAddrobj::tableName() . '.' . 'aolevel' => FiasAddrobj::AOLEVEL_CITY,
					FiasAddrobj::tableName() . '.actstatus' => 1
			])
			->andWhere(FiasAddrobj::tableName() . '.formalname LIKE :query')
			->createCommand()
			->bindValues([
				':query' => $query . '%',
			]);
		$this->ajaxResponse->data = $citiesCommand->queryAll();

		return ;
	}

	public function actionStreets() {
		//@TODO: добавить проверку guid-а города
		$cityGuid = Yii::$app->request->post('cityGuid');
		$query = Yii::$app->request->post('query');
		Yii::$app->response->format = Response::FORMAT_JSON;
		$citiesCommand = FiasAddrobj::find()
			->select([FiasAddrobj::tableName() . '.aoguid AS id', FiasAddrobj::tableName() . '.formalname AS title'])
			->where([
				FiasAddrobj::tableName() . '.' . 'aolevel' => FiasAddrobj::AOLEVEL_STREET,
				FiasAddrobj::tableName() . '.actstatus' => 1
			])
			->andWhere(FiasAddrobj::tableName() . '.parentguid = :city_guid')
			->andWhere(FiasAddrobj::tableName() . '.formalname LIKE :query')
			->createCommand()
			->bindValues([
				':city_guid' => $cityGuid,
				':query' => $query . '%',
			]);

		$this->ajaxResponse->data = $citiesCommand->queryAll();

		return ;
	}

}