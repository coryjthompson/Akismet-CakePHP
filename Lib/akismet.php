<?php
/**
 * CakePHP Akismet Plugin for CakePHP 2.x
 *
 * @copyright Copyright 2012, coryjthompson.com (http://coryjthompson.com/)
 * @link https://github.com/coryjthompson/Akismet-CakePHP
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::uses('HttpSocket', 'Network/Http');

class Akismet extends HttpSocket {
	private $__version = '1.1';
	private $__key;
	private $__blog;

	public function __construct($key, $blog){
		$this->__key = $key;
		$this->__blog = $blog;
	
		if(!$this->isKeyValid()){
			throw new Exception("Invalid Akismet API key");
		}
	}

	public function isSpam($data){
		$data['blog'] = $this->__blog;
		$result = $this->__query('comment-check', $data);
		return $result == 'true';
	}

	public function notSpam($data){
		$data['blog'] = $this->__blog;
		$result = $this->__query('submit-ham', $data);
		return $result == 'true';
	}

	public function markSpam($data){
		$data['blog'] = $this->__blog;
		$result = $this->__query('submit-spam', $data);
		return $result == 'true';
	}

	public function isKeyValid(){
		$data = array(
			'key' => $this->__key,
			'blog' => $this->__blog
		);

		return $this->__query('verify-key', $data) == 'valid';
	}

	private function __query($type, $data = array()){
		$acceptedTypes = array('verify-key', 'comment-check', 'submit-spam', 'submit-ham');

		if(!in_array($type, $acceptedTypes)) {
			throw new Exception(sprintf('Unknown query type: "%s"', $type));
		}

		if($type == 'verify-key') {
			$apiUrl = sprintf('http://rest.akismet.com/%s/verify-key', $this->__version);
		} else {
			$apiUrl = sprintf('http://%s.rest.akismet.com/%s/%s', $this->__key, $this->__version, $type);
		}
		$result = $this->post($apiUrl, $data);

		if($result->code != 200){
			throw new Exception('Akismet API returned response: ' . $result->code);
		}

		if($result == 'invalid') {
			throw new Exception('Akismet API returned invalid. Check API key');
		}
		return $result;
	}
}

?>
