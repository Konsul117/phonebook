<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\i18n;

class Formatter extends \yii\i18n\Formatter {

	public function asDate($value, $format = null) {
		return date('d.m.Y H:i', strtotime($value));
	}

}
