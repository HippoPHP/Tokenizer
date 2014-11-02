<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Token;

	class TokenizerTest extends \PHPUnit_Framework_TestCase {
		public function testNewInstance() {
			$this->assertInstanceOf('\HippoPHP\Tokenizer\Token', new Token);
		}
	}