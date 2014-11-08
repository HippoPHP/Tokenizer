<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class BooleanTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_BOOLEAN;
		}

		public function getMatcher() {
			return (new StringMatcher([
				'true',
				'false',
			]))->setCaseSensitive(false);
		}

		public function getPriority() {
			return 90;
		}
	}
