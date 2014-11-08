<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class EolTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_EOL;
		}

		public function getMatcher() {
			return new RegexMatcher('[\r\n]+');
		}

		public function getPriority() {
			return 90;
		}
	}
