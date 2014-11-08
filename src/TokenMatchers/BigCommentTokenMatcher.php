<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class BigCommentTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_BIG_COMMENT;
		}

		protected function getMatcher() {
			return new RegexMatcher('\/\*.*\*\/');
		}

		public function getPriority() {
			return 100;
		}
	}
