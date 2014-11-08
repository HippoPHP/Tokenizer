<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class CompileTimeConstantTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_COMPILETIME_CONSTANT;
		}

		public function getMatcher() {
			return new StringMatcher([
				'__CLASS__',
				'__DIR__',
				'__FILE__',
				'__FUNCTION__',
				'__LINE__',
				'__METHOD__',
				'__NAMESPACE__',
				'__TRAIT__',
			]);
		}

		public function getPriority() {
			return 90;
		}
	}
