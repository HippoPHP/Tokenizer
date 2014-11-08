<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class HereDocTest extends AbstractTokenizationTest {
		/**
		 * @dataProvider goodHeredocProvider
		 */
		public function testBasic($source) {
			$tokens = $this->tokenizer->tokenize($source);
			$this->assertTokenTypes([ TokenType::TOKEN_HEREDOC], $tokens);
			$this->assertTokenContent([ $source ], $tokens);
		}

		/**
		 * @dataProvider badHeredocProvider
		 */
		public function testNotHeredoc($source) {
			$tokens = $this->tokenizer->tokenize($source);
			$this->assertNotEquals(TokenType::TOKEN_HEREDOC, $tokens[0]->getType());
		}

		public function goodHeredocProvider() {
			return [['<<<"EOF"
	what is life
		I don\'t want to be Godzilla
EOF'], ['<<<EOF
	what is life
		I don\'t want to be Godzilla
EOF'], ['<<<EOF
me neither
EOF;']];
		}


		public function badHeredocProvider() {
			return [
//TODO: why does this fail?
/*['<<<"EOF"
nope
"EOF"'], */['<<<EOF
nope
EOFF'], ['<<<EOF
nope
EOF)'], ['<<<0NUMBER
nope
0NUMBER)']];
		}
	}
