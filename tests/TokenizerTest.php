<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Tokenizer;

	class TokenizerTest extends \PHPUnit_Framework_TestCase {
		private $_tokenizer;

		public function testNewInstance() {
			$this->assertInstanceOf('\HippoPHP\Tokenizer\Tokenizer', new Tokenizer);
		}
	}
