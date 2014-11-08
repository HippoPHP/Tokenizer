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
			$this->tokenList->rewind();
			$this->assertEquals(0, $this->tokenList->key());
		}

		public function testMoveAround() {
			$this->tokenList->next();
			$this->tokenList->prev();
			$this->assertEquals(0, $this->tokenList->key());
		}

		public function testIsValid() {
			$this->tokenList->next();
			$this->assertTrue($this->tokenList->valid());
		}

		public function testSeekToType() {
			$seekToken = new Token(TokenType::TOKEN_WHITESPACE, "\t", 2, 1);
			$this->assertEquals($seekToken, $this->tokenList->seekToType(TokenType::TOKEN_WHITESPACE));
		}

		public function testSkipTypes() {
			$ignoreTokens = [
				new Token(TokenType::TOKEN_OPEN_TAG, '<?php', 1, 1),
				new Token(TokenType::TOKEN_EOL, "\t", 2, 1)
			];

			$shouldBeToken = new Token(TokenType::TOKEN_WHITESPACE, "\t", 2, 1);
			$this->assertEquals($shouldBeToken, $this->tokenList->skipTypes($ignoreTokens));
		}
	}
