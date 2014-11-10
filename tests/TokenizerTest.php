<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\Tokenizer;

	class TokenizerTest extends \PHPUnit_Framework_TestCase {
		private $_tokenizer;

		public function setUp() {
			$this->_tokenizer = new Tokenizer();
		}

		public function testTokenize() {
			$this->_tokenizer->tokenize(
<<<ETEST
<?php
	echo \$var;
ETEST
			);
		}
	}
