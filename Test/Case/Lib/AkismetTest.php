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

	public function testValidApiKey(){
		//only valid if Akismet/Config/config.php is correct
		Configure::load('Akismet.config');
		$settings = Configure::read('akismet');
		$this->akismetObj = new Akismet($settings['key'], $settings['blog']);
	}

	public function testSpam(){
		$comment = array(
				'user_ip' => '127.0.0.1',
				'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11',
				'comment_author' => 'viagra-test-123',
				'comment_author_email' => 'viagra@viagra.com',
				'comment_author_url' => 'buymypillypilles.com',
				'comment_content' => 'spam spam spam'
			);

		$akismetObj = new Akismet(Configure::read('akismet.key'), Configure::read('akismet.blog'));
		$result = $akismetObj->isSpam($comment);
		$this->assertTrue($result);			
	}

}
