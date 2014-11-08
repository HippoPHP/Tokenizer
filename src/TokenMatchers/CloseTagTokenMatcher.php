<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class CloseTagTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_CLOSE_TAG;
		}

		protected function getMatcher() {
			return new StringMatcher(['%>', '?>']);
		}

		public function getPriority() {
			return 90;
		}
	}
