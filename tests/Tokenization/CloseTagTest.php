<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class CloseTagTest extends AbstractTokenizationTest {
		public function testBasic() {
			$tokens = $this->tokenizer->tokenize('?>');
			$this->assertTokenTypes([TokenType::TOKEN_CLOSE_TAG], $tokens);
			$this->assertTokenContent(['?>'], $tokens);
		}
	}
