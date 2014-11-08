<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class QuotedStringTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_QUOTED_STRING;
		}

		protected function getMatcher() {
			return new RegexMatcher('(["\'])(?:(?!\1)[^\\\]|\\\.)*\1');
		}

		public function getPriority() {
			return 100;
		}
	}
