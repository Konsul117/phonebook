<?php

namespace app\controllers;

use app\components\AjaxResponse;
use app\components\validators\GuidValidator;
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
		Yii::$app->response->format = Response::FORMAT_JSON;

		//@TODO: добавить проверку результата запроса и указание result, error у responce
		$query = Yii::$app->request->post('query');

		$this->ajaxResponse->success = true;

		$citiesCommand = FiasAddrobj::find()
			->select([FiasAddrobj::tableName() . '.aoguid AS id', FiasAddrobj::tableName() . '.formalname AS title'])
			->where([
					FiasAddrobj::tableName() . '.' . 'aolevel' => FiasAddrobj::AOLEVEL_CITY,
					FiasAddrobj::tableName() . '.actstatus' => 1
			])
			->andWhere(FiasAddrobj::tableName() . '.formalname LIKE :query')
			->limit(10)
			->orderBy(['formalname' => SORT_ASC])
			->createCommand()
			->bindValues([
				':query' => $query . '%',
			]);

		$data = $citiesCommand->queryAll();

		if (!empty($data)) {
			$this->ajaxResponse->data = $data;
		}
		else {
			$this->ajaxResponse->errors[] = 'Города не найдены';
			$this->ajaxResponse->success = false;
		}

		return ;
	}

	public function actionStreets() {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$cityGuid = Yii::$app->request->post('cityGuid');
		if ((new GuidValidator())->validate($cityGuid) === false) {
			$this->ajaxResponse->success = false;
			$this->ajaxResponse->errors[] = 'Не выбран город';

			return ;
		}

		$this->ajaxResponse->success = true;

		$query = Yii::$app->request->post('query');
		$streetsCommand = FiasAddrobj::find()
			->select([FiasAddrobj::tableName() . '.aoguid AS id', FiasAddrobj::tableName() . '.formalname AS title'])
			->where([
				FiasAddrobj::tableName() . '.' . 'aolevel' => FiasAddrobj::AOLEVEL_STREET,
				FiasAddrobj::tableName() . '.actstatus' => 1
			])
			->andWhere(FiasAddrobj::tableName() . '.parentguid = :city_guid')
			->andWhere(FiasAddrobj::tableName() . '.formalname LIKE :query')
			->limit(10)
			->orderBy(['formalname' => SORT_ASC])
			->createCommand()
			->bindValues([
				':city_guid' => $cityGuid,
				':query' => $query . '%',
			]);

		$data = $streetsCommand->queryAll();

		if (!empty($data)) {
			$this->ajaxResponse->data = $data;
		}
		else {
			$this->ajaxResponse->errors[] = 'Улицы не найдены';
			$this->ajaxResponse->success = false;
		}

		return ;
	}

}