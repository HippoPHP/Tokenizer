<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class DocTest extends AbstractTokenizationTest {
		/**
		 * @dataProvider gooddocProvider
		 */
		public function testBasic($source) {
			$tokens = $this->tokenizer->tokenize($source);
			$this->assertTokenTypes([ TokenType::TOKEN_DOC], $tokens);
			$this->assertTokenContent([ $source ], $tokens);
		}

		/**
		 * @dataProvider badDocProvider
		 */
		public function testBadDoc($source) {
			$tokens = $this->tokenizer->tokenize($source);
			$this->assertNotEquals(TokenType::TOKEN_DOC, $tokens[0]->getType());
		}

		public function gooddocProvider() {
			return [['<<<"EOF"
	what is life
EOF'], ['<<<EOF
I don\'t want to be Godzilla
EOF'], ['<<<EOF
me neither
EOF;'], ['<<<\'EOF\'
but single quotes are fine.
EOF']];
		}


		public function badDocProvider() {
			return [
//TODO: why do these fail?
/*['<<<"EOF"
nope
"EOF"'], ['<<<\'EOF\'
nope
\'EOF\''], */['<<<EOF
nope
EOFF'], ['<<<EOF
nope
EOF)'], ['<<<0NUMBER
nope
0NUMBER)']];
		}
	}
