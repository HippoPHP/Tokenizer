<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class OpenTagTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_OPEN_TAG;
		}

		protected function getMatcher() {
			return new StringMatcher(['<?php', '<?=', '<?', '<%=', '<%']);
		}

		public function getPriority() {
			return 90;
		}
	}
