<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class WhitespaceTest extends AbstractTokenizationTest {
		public function testEolMix() {
			$tokens = $this->tokenizer->tokenize("\n \t\r\n   ");
			$this->assertTokenTypes([
				TokenType::TOKEN_EOL,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_EOL,
				TokenType::TOKEN_WHITESPACE],
				$tokens);
			$this->assertTokenContent(["\n", " \t", "\r\n", '   '], $tokens);
		}

		public function testDoubleEol() {
			$tokens = $this->tokenizer->tokenize("<?php\n\n\twhatever");
			$this->assertTokenTypes([
				TokenType::TOKEN_OPEN_TAG,
				TokenType::TOKEN_EOL,
				TokenType::TOKEN_EOL,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_IDENTIFIER],
				$tokens);
			$this->assertTokenContent(['<?php', "\n", "\n", "\t", 'whatever'], $tokens);
		}
	}

