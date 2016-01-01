<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {

	public $name;
	public $surname;
	public $phone;
	public $address;
	public $city;
	public $city_guid;
	public $street;
	public $street_guid;

	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * @return array the validation rules.
	 */
	public function rules() {
		return [
			// name, email, subject and body are required
			[['name', 'email', 'subject', 'body'], 'required'],
			// email has to be a valid email address
			['email', 'email'],
			// verifyCode needs to be entered correctly
			['verifyCode', 'captcha'],
		];
	}

	/**
	 * @return array customized attribute labels
	 */
	public function attributeLabels() {
		// @TODO: доделать лейблы и убрать их из вьюхи
		return [
			'verifyCode' => 'Verification Code',
			'street'     => 'Улица',
		];
	}

	/**
	 * Sends an email to the specified email address using the information collected by this model.
	 *
	 * @param  string $email the target email address
	 * @return boolean whether the model passes validation
	 */
	public function contact($email) {
		if ($this->validate()) {
			Yii::$app->mailer->compose()
				->setTo($email)
				->setFrom([$this->email => $this->name])
				->setSubject($this->subject)
				->setTextBody($this->body)
				->send();

			return true;
		}
		else {
			return false;
		}
	}

	public function saveContact() {

	}
}
