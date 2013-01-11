<?php
App::uses('Akismet', 'Akismet.Lib');

class AkismetTest extends CakeTestCase {
	private $akismetObj;
	public function setup(){
	}

	public function testIncorrectApiKeyFails(){
		try {
			$akismetObj = new Akismet('failme', 'failme');
			$this->fail('Did not error on invalid api keys');
		} catch(Exception $e){
			$this->assertEqual("Akismet API returned invalid. Check API key", $e->getMessage());
		}

	}

	public function testSpam(){
		return false;
	}

}
