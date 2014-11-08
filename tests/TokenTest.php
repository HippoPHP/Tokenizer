<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\TokenType;

	class TokenTest extends \PHPUnit_Framework_TestCase {
		protected $token;

		public function setUp() {
			$this->token = new Token(TokenType::TOKEN_OPEN_TAG, '<?php', 1, 1);
		}

		public function testGetType() {
			$this->assertEquals(TokenType::TOKEN_OPEN_TAG, $this->token->getType());
		}

		public function testGetContent() {
			$this->assertEquals('<?php', $this->token->getContent());
		}

		public function testGetLine() {
			$this->assertEquals(1, $this->token->getLine());
		}

		public function testGetColumn() {
			$this->assertEquals(1, $this->token->getColumn());
		}
	}
