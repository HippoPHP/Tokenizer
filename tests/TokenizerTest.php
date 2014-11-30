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

		public function testColumnAndEol() {
			$tokenList = $this->_tokenizer->tokenize(
<<<ETEST
<?php

	1 + 2

	+
	'test'4
ETEST
			);
			$this->assertNotNull($tokenList);
			$this->assertNotNull($tokenList->getTokens());

			$tokens = $tokenList->getTokens();
			$this->assertEquals(12, count($tokens));
			$this->assertEquals([
					new Token(T_OPEN_TAG, "<?php\n", 1, 1),
					new Token(T_WHITESPACE, "\n\t", 2, 1),
					new Token(T_LNUMBER, '1', 3, 2),
					new Token(T_WHITESPACE, ' ', 3, 3),
					new Token(0, '+', 3, 4), //TODO: why is this "0"
					new Token(T_WHITESPACE, ' ', 3, 5),
					new Token(T_LNUMBER, '2', 3, 6),
					new Token(T_WHITESPACE, "\n\n\t", 3, 7),
					new Token(0, '+', 5, 2), //TODO: why is this "0"
					new Token(T_WHITESPACE, "\n\t", 5, 3),
					new Token(T_CONSTANT_ENCAPSED_STRING, '\'test\'', 6, 2),
					new Token(T_LNUMBER, '4', 6, 8),
				], $tokens);
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
	}
