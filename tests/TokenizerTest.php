<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\Tokenizer;
	use \HippoPHP\Tokenizer\Exception\InvalidArgumentException;

	class TokenizerTest extends \PHPUnit_Framework_TestCase {
		private $_tokenizer;

		public function setUp() {
			$this->_tokenizer = new Tokenizer();
		}

		public function testConstructor() {
			$this->assertInstanceOf('\HippoPHP\Tokenizer\Tokenizer', new Tokenizer());
		}

		public function testTokenize() {
			$tokenList = $this->_tokenizer->tokenize(
<<<ETEST
<?php
	echo \$var;
ETEST
			);

			$this->assertNotNull($tokenList->getTokens());
			$this->assertTrue($tokenList->count() > 0);
			$this->assertInstanceOf('\HippoPHP\Tokenizer\TokenListIterator', $tokenList);
		}

		public function testTokenizeNullBuffer() {
			$tokenizer = new Tokenizer;
			$this->assertEmpty($tokenizer->tokenize(null));
		}

		/**
		 * @expectedException \HippoPHP\Tokenizer\Exception\InvalidArgumentException
		 */
		public function testTokenizeInvalidArgument() {
			$tokenizer = new Tokenizer;
			$tokenizer->tokenize([]);
		}

		public function testGetTokens() {
			$this->assertInstanceOf('\HippoPHP\Tokenizer\TokenListIterator', $this->_tokenizer->getTokenList());
		}
	}
