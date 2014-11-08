<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class CommentTest extends AbstractTokenizationTest {
		public function testBasic() {
			$tokens = $this->tokenizer->tokenize(<<<EOF
	/**
	 * life
	 * is
	 * comment
	 */
	\$a = 5; //comment
EOF
);
			$this->assertTokenTypes([
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_BIG_COMMENT,
				TokenType::TOKEN_EOL,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_VARIABLE,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_OPERATOR,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_IDENTIFIER,
				TokenType::TOKEN_SEMICOLON,
				TokenType::TOKEN_WHITESPACE,
				TokenType::TOKEN_SMALL_COMMENT],
				$tokens);

			$this->assertTokenContent([
				"\t",
				<<<EOF
/**
	 * life
	 * is
	 * comment
	 */
EOF
,
				"\n",
				"\t",
				'$a',
				' ',
				'=',
				' ',
				'5',
				';',
				' ',
				'//comment'],
				$tokens);
		}
	}

