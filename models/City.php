<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dn_city_1c".
 *
 * @property integer $id
 * @property string $id_1c
 * @property integer $parent_id
 * @property string $code
 * @property integer $region_id
 * @property integer $region_global_id
 * @property string $region_1c
 * @property string $title
 * @property string $title_1c
 * @property integer $gmt
 * @property integer $sort_id
 * @property string $geoip_city
 * @property string $path
 * @property string $alternative_path
 * @property string $old_path
 * @property integer $old_region_id
 * @property integer $is_deleted
 * @property integer $is_published
 * @property integer $timezone
 * @property string $service_center
 * @property string $manufacturer_service_center
 * @property string $yandex_confirm_code
 * @property string $yandex_confirm_code_tp
 * @property string $yandex_confirm_code_bazar
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dn_city_1c';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_1c', 'parent_id', 'code', 'region_id', 'region_global_id', 'region_1c', 'title', 'title_1c', 'gmt', 'sort_id', 'geoip_city', 'path', 'alternative_path', 'old_path', 'old_region_id', 'is_deleted', 'is_published', 'timezone', 'service_center', 'manufacturer_service_center', 'yandex_confirm_code', 'yandex_confirm_code_tp', 'yandex_confirm_code_bazar'], 'required'],
            [['parent_id', 'region_id', 'region_global_id', 'gmt', 'sort_id', 'old_region_id', 'is_deleted', 'is_published', 'timezone'], 'integer'],
            [['service_center', 'manufacturer_service_center'], 'string'],
            [['id_1c'], 'string', 'max' => 36],
            [['code'], 'string', 'max' => 16],
            [['region_1c', 'path', 'old_path'], 'string', 'max' => 64],
            [['title', 'title_1c', 'geoip_city', 'alternative_path'], 'string', 'max' => 255],
            [['yandex_confirm_code', 'yandex_confirm_code_bazar'], 'string', 'max' => 250],
            [['yandex_confirm_code_tp'], 'string', 'max' => 100],
            [['id_1c'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_1c' => 'Id 1c',
            'parent_id' => 'Parent ID',
            'code' => 'Code',
            'region_id' => 'Region ID',
            'region_global_id' => 'Region Global ID',
            'region_1c' => 'Region 1c',
            'title' => 'Title',
            'title_1c' => 'Title 1c',
            'gmt' => 'Gmt',
            'sort_id' => 'Sort ID',
            'geoip_city' => 'Geoip City',
            'path' => 'Path',
            'alternative_path' => 'Alternative Path',
            'old_path' => 'Old Path',
            'old_region_id' => 'Old Region ID',
            'is_deleted' => 'Is Deleted',
            'is_published' => 'Is Published',
            'timezone' => 'Timezone',
            'service_center' => 'Service Center',
            'manufacturer_service_center' => 'Manufacturer Service Center',
            'yandex_confirm_code' => 'Yandex Confirm Code',
            'yandex_confirm_code_tp' => 'Yandex Confirm Code Tp',
            'yandex_confirm_code_bazar' => 'Yandex Confirm Code Bazar',
        ];
    }
}
