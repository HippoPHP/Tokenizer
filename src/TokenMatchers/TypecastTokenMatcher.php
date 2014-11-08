<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class TypecastTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_TYPECAST;
		}

		public function getMatcher() {
			return (new StringMatcher([
				'integer', 'int',
				'boolean', 'bool',
				'float', 'double', 'real',
				'string',
				'array',
				'object',
				'unset',
				'binary',
			]))->setCaseSensitive(false);
		}

		public function getPriority() {
			return 90;
		}
	}
