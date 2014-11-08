<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class BackticksStringTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_BACKTICKS_STRING;
		}

		protected function getMatcher() {
			return new RegexMatcher('`(?:(?!`)[^\\\]|\\\.)*`');
		}

		public function getPriority() {
			return 100;
		}
	}
