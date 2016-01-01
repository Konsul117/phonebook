<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "d_fias_addrobj".
 *
 * @property string  $aoid
 * @property string  $formalname
 * @property string  $regioncode
 * @property string  $autocode
 * @property string  $areacode
 * @property string  $citycode
 * @property string  $ctarcode
 * @property string  $placecode
 * @property string  $streetcode
 * @property string  $extrcode
 * @property string  $sextcode
 * @property string  $offname
 * @property string  $postalcode
 * @property string  $ifnsfl
 * @property string  $terrifnsfl
 * @property string  $ifnsul
 * @property string  $terrifnsul
 * @property string  $okato
 * @property string  $oktmo
 * @property string  $updatedate
 * @property string  $shortname
 * @property integer $aolevel
 * @property string  $parentguid
 * @property string  $aoguid
 * @property string  $previd
 * @property string  $nextid
 * @property string  $code
 * @property string  $plaincode
 * @property integer $actstatus
 * @property integer $centstatus
 * @property integer $operstatus
 * @property integer $currstatus
 * @property string  $startdate
 * @property string  $enddate
 * @property string  $normdoc
 */
class FiasAddrobj extends \yii\db\ActiveRecord {

	const AOLEVEL_CITY   = 4;
	const AOLEVEL_STREET = 7;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'd_fias_addrobj';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['aoid', 'formalname', 'regioncode', 'autocode', 'areacode', 'citycode', 'ctarcode', 'placecode', 'streetcode', 'extrcode', 'sextcode', 'offname', 'postalcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul', 'okato', 'oktmo', 'updatedate', 'shortname', 'aolevel', 'parentguid', 'aoguid', 'previd', 'nextid', 'code', 'plaincode', 'actstatus', 'centstatus', 'operstatus', 'currstatus', 'startdate', 'enddate', 'normdoc'], 'required'],
			[['updatedate', 'startdate', 'enddate'], 'safe'],
			[['aolevel', 'actstatus', 'centstatus', 'operstatus', 'currstatus'], 'integer'],
			[['aoid', 'parentguid', 'aoguid', 'previd', 'nextid', 'normdoc'], 'string', 'max' => 36],
			[['formalname', 'offname'], 'string', 'max' => 120],
			[['regioncode'], 'string', 'max' => 2],
			[['autocode'], 'string', 'max' => 1],
			[['areacode', 'citycode', 'ctarcode', 'placecode', 'sextcode'], 'string', 'max' => 3],
			[['streetcode', 'extrcode', 'ifnsfl', 'terrifnsfl', 'ifnsul', 'terrifnsul'], 'string', 'max' => 4],
			[['postalcode'], 'string', 'max' => 6],
			[['okato'], 'string', 'max' => 11],
			[['oktmo'], 'string', 'max' => 8],
			[['shortname'], 'string', 'max' => 10],
			[['code'], 'string', 'max' => 17],
			[['plaincode'], 'string', 'max' => 15],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'aoid'       => 'Уникальный идентификатор записи',
			'formalname' => 'Формализованное наименование',
			'regioncode' => 'Код региона',
			'autocode'   => 'Код автономии',
			'areacode'   => 'Код района',
			'citycode'   => 'Код города',
			'ctarcode'   => 'Код внутригородского района',
			'placecode'  => 'Код населенного пункта',
			'streetcode' => 'Код улицы',
			'extrcode'   => 'Код дополнительного адресообразующего элемента',
			'sextcode'   => 'Код подчиненного дополнительного адресообразующего элемента',
			'offname'    => 'Официальное наименование',
			'postalcode' => 'Почтовый индекс',
			'ifnsfl'     => 'Код ИФНС ФЛ',
			'terrifnsfl' => 'Код территориального участка ИФНС ФЛ',
			'ifnsul'     => 'Код ИФНС ЮЛ',
			'terrifnsul' => 'Код территориального участка ИФНС ЮЛ',
			'okato'      => 'ОКАТО',
			'oktmo'      => 'ОКТМО',
			'updatedate' => 'Дата  внесения записи',
			'shortname'  => 'Краткое наименование типа объекта',
			'aolevel'    => 'Уровень адресного объекта ',
			'parentguid' => 'Идентификатор объекта родительского объекта',
			'aoguid'     => 'Глобальный уникальный идентификатор адресного объекта',
			'previd'     => 'Идентификатор записи связывания с предыдушей исторической записью',
			'nextid'     => 'Идентификатор записи  связывания с последующей исторической записью',
			'code'       => 'Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0',
			'plaincode'  => 'Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)',
			'actstatus'  => 'Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.',
			'centstatus' => 'Статус центра',
			'operstatus' => 'Статус действия над записью – причина появления записи',
			'currstatus' => 'Статус актуальности КЛАДР 4 (последние две цифры в коде)',
			'startdate'  => 'Начало действия записи',
			'enddate'    => 'Окончание действия записи',
			'normdoc'    => 'Внешний ключ на нормативный документ',
		];
	}
}
