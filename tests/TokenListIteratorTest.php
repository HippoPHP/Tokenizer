<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\TokenListIterator;
	use \HippoPHP\Tokenizer\Exception\OutOfBoundsException;

	class TokenListIteratorTest extends \PHPUnit_Framework_TestCase {
		protected $tokenList;
		protected $tokens;

		public function setUp() {
			$this->tokenList = new TokenListIterator;

			// Make some tokens.
			$this->tokens = [
				new Token(TokenType::TOKEN_OPEN_TAG, '<?php', 1, 1),
				new Token(TokenType::TOKEN_EOL, "\n", 1, 1),
				new Token(TokenType::TOKEN_WHITESPACE, "\t", 2, 1),
				new Token(TokenType::TOKEN_VARIABLE, '$var', 2, 1),
			];

			$this->tokenList->setTokens($this->tokens);
		}

		public function testGetTokens() {
			$this->assertSame($this->tokens, $this->tokenList->getTokens());
		}

		public function testGetCount() {
			$this->assertEquals(count($this->tokens), $this->tokenList->count());
		}

		/**
		 * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
		 */
		public function testSeekOutOfRange() {
			$this->tokenList->seek(999);
		}

		public function testSeekValid() {
			$this->tokenList->seek(1);
			$this->assertEquals(1, $this->tokenList->key());
		}

		public function testRewind() {
			$this->tokenList->next();
			$this->tokenList->rewind();
			$this->assertEquals(0, $this->tokenList->key());
		}

		public function testMoveAround() {
			$this->tokenList->next();
			$this->assertEquals(1, $this->tokenList->key());
			$this->tokenList->prev();
			$this->assertEquals(0, $this->tokenList->key());
		}

		public function testIsValid() {
			$this->assertTrue($this->tokenList->valid());
			$this->tokenList->seek(count($this->tokenList) - 1);
			$this->tokenList->next();
			$this->assertFalse($this->tokenList->valid());
		}

		public function testSeekToType() {
			$seekToken = new Token(TokenType::TOKEN_WHITESPACE, "\t", 2, 1);
			$this->assertEquals($seekToken, $this->tokenList->seekToType(TokenType::TOKEN_WHITESPACE));
		}

		/**
		 * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
		 */
		public function testSeekToNonExistingType() {
			$this->tokenList->seekToType(TokenType::TOKEN_DOC);
		}

		public function testSkipTypes() {
			$ignoreTokens = [
				TokenType::TOKEN_OPEN_TAG,
				TokenType::TOKEN_EOL,
			];

			$expectedToken = new Token(TokenType::TOKEN_WHITESPACE, "\t", 2, 1);
			$this->assertEquals($expectedToken, $this->tokenList->skipTypes($ignoreTokens));
		}

		public function testSkipNonexistingTypes() {
			$actualToken = $this->tokenList->skipTypes([TokenType::TOKEN_DOC]);
			$this->assertNotNull($actualToken);
			$this->assertEquals(TokenType::TOKEN_OPEN_TAG, $actualToken->getType());
		}
	}
