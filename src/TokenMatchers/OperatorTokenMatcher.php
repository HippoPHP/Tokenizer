<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class OperatorTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_OPERATOR;
		}

		public function getMatcher() {
			return new StringMatcher([
				// Scope and classes
				'::', '->',
				// Incrementing
				'++', '+=',
				// Decrementing
				'--', '-=',
				// Arithmetic
				'**=', '%=', '/=', '*=', '**', '*', '%', '/', '-', '+',
				// Bitwise
				'<<=', '>>=', '&&', '||', '|=', '&=', '<<', '>>', '^=',
				'&', '|', '^', '~',
				// Comparison
				'===', '!==', '==', '<>', '!=', '<=', '>=', '<', '>',
				// Logical
				'and', 'or', 'xor', '!',
				// Error Supression
				'@',
				// Ternary
				'?', ':',
				// Concatenation
				'.',
				// Assignment
				'=',
				// Other
				'instanceof',
			]);
		}

		public function getPriority() {
			return -100;
		}
	}
