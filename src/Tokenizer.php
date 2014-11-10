<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	use \RecursiveDirectoryIterator;
	use \RecursiveIteratorIterator;
	use \RegexIterator;
	use \ReflectionClass;

	class Tokenizer {
		/**
		 * @param string $buffer
		 * @return array
		 */
		public function tokenize($buffer) {
			if ($buffer === null) {
				return [];
			} elseif (!is_string($buffer)) {
				throw new \Exception('Buffer must be a string.');
			}

			return token_get_all($buffer);
		}
	}
