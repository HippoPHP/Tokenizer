<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class IdentifierTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_IDENTIFIER;
		}

		public function getMatcher() {
			return new RegexMatcher('\w+');
		}

		public function getPriority() {
			return -200;
		}
	}
