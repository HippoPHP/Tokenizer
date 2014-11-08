<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class KeywordTest extends AbstractTokenizationTest {
		public function testBasic() {
			$tokens = $this->tokenizer->tokenize('function class trait');
			$this->assertTokenTypes([
				TokenType::TOKEN_KEYWORD,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_KEYWORD,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_KEYWORD],
				$tokens);
			$this->assertTokenContent(['function', ' ', 'class', ' ', 'trait'], $tokens);
		}
	}
