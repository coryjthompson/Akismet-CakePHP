<?php
/**
 * CakePHP Akismet Plugin for CakePHP 2.x
 *
 * @copyright Copyright 2012, coryjthompson.com (http://coryjthompson.com/)
 * @link https://github.com/coryjthompson/Akismet-CakePHP
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::uses('Akismet', 'Akismet.Lib');

class AkismetBehavior extends ModelBehavior {
	private $__akismetObj;

	public function setup(Model $Model, $settings) {
		/*if(!isset($this->settings[$Model->alias])){
			$this->settings[$Model->alias] = array(
				'fields' => array(
					'author' => 'name',
					'email' => 'email',
					'url' => 'url',
					'content' => 'content',
					'spam' => 'spam'
				),
				'key' => '',
				'blog' => 'http://coryjthompson.com'
			);
		}*/
		Configure::load('Akismet.config');
		$this->settings[$Model->alias] = Configure::read('akismet');

		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias],(array)$settings);
		$this->__akismetObj = new Akismet($this->settings[$Model->alias]['key'], $this->settings[$Model->alias]['blog']);
	}

	public function beforeSave(Model $model){

		parent::beforeSave($model);

		if(!$model->id && !isset($model->data[$model->alias][$model->primaryKey])){
			if($this->isSpam($model)){
				$model->data[$model->alias][$this->settings[$model->alias]['fields']['spam']] = 1;
			} else {
				$model->data[$model->alias][$this->settings[$model->alias]['fields']['spam']] = 0;
			};
		}
		return true;
	}

	public function isSpam(&$model) {
		$query = $this->__getQueryData($model);
		return $this->__akismetObj->isSpam($query);
	}

	public function notSpam(&$model){
		$query = $this->__getQueryData($model);
		return $this->__akismetObj->notSpam($query);
	}

	public function markSpam(&$model){
		$query = $this->__getQueryData($model);
		return $this->__akismetObj->markSpam($query);
	}

	public function isKeyValid(){
		return $this->__akismetObj->isKeyValid();
	}

	private function __getQueryData(&$model){
		$query = array(
			'user_ip' => env('REMOTE_ADDR'),
			'user_agent' => env('HTTP_USER_AGENT'),
			'comment_author' => $model->data[$model->alias][$this->settings[$model->alias]['fields']['author']],
			'comment_author_email' => $model->data[$model->alias][$this->settings[$model->alias]['fields']['email']],
			'comment_author_url' => $model->data[$model->alias][$this->settings[$model->alias]['fields']['url']],
			'comment_content' => $model->data[$model->alias][$this->settings[$model->alias]['fields']['content']]
		);

		return $query;
	}
}
