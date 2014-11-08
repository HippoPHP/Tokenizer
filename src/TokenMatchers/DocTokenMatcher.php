<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class DocTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_DOC;
		}

		protected function getMatcher() {
			return new RegexMatcher('<<<(["\']?)([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\1[\r\n].*^\2($|;)');
		}

		public function getPriority() {
			return 100;
		}
	}
