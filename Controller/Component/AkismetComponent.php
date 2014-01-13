<?php
/**
 * CakePHP Akismet Plugin for CakePHP 2.x
 *
 * @copyright Copyright 2012, coryjthompson.com (http://coryjthompson.com/)
 * @link https://github.com/coryjthompson/Akismet-CakePHP
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::uses('Akismet', 'Akismet.Lib');

class AkismetComponent extends Component {
	private $__akismetObj;

	public function initialize(Controller $controller) {
		Configure::load('Akismet.config');
		$settings = Configure::read('akismet');

		$this->__akismetObj = new Akismet($settings['key'], $settings['blog']);
	}

	public function isSpam($content, $author, $authorEmail, $authorUrl=null) {
		$query = $this->__getQueryData($content, $author, $authorEmail, $authorUrl);
		return $this->__akismetObj->isSpam($query);
	}

	public function notSpam($content, $author, $authorEmail, $authorUrl=null){
		$query = $this->__getQueryData($content, $author, $authorEmail, $authorUrl);
		return $this->__akismetObj->notSpam($query);
	}

	public function markSpam($content, $author, $authorEmail, $authorUrl=null){
		$query = $this->__getQueryData($model);
		return $this->__akismetObj->markSpam($query);
	}

	public function isKeyValid(){
		return $this->__akismetObj->isKeyValid();
	}

	private function __getQueryData($content, $author, $authorEmail, $authorUrl=nul){
		$query = array(
			'user_ip' => env('REMOTE_ADDR'),
			'user_agent' => env('HTTP_USER_AGENT'),
			'comment_author' => $author,
			'comment_author_email' => $authorEmail,
			'comment_author_url' => $authorUrl,
			'comment_content' => $content
		);

		return $query;
	}
}
