<?php

	namespace HippoPHP\Tokenizer\Matchers;

	use \HippoPHP\Tokenizer\Matchers\MatcherInterface;

	class StringMatcher implements MatcherInterface {
		private $_values;

		public function __construct($values) {
			if (is_array($values)) {
				$this->_values = $values;
			} else {
				$this->_values = [$values];
			}
		}

		/**
		 * @param string $content
		 * @return string|null
		 */
		public function match($content) {
			foreach ($this->_values as $value) {
				if (strncmp($content, $value, strlen($value)) === 0) {
					return $value;
				}
			}
			return null;
		}
	}
