<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class OpenTagTest extends AbstractTokenizationTest {
		public function testBasic() {
			$tokens = $this->tokenizer->tokenize('<?php');
			$this->assertTokenTypes([TokenType::TOKEN_OPEN_TAG], $tokens);
			$this->assertTokenContent(['<?php'], $tokens);
		}
	}
