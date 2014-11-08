<?php

	namespace HippoPHP\Tokenizer\Matchers;

	use \HippoPHP\Tokenizer\Matchers\MatcherInterface;

	class StringMatcher implements MatcherInterface {
		private $_values;
		private $_function = 'strncmp';

		public function __construct($values) {
			if (is_array($values)) {
				$this->_values = $values;
			} else {
				$this->_values = [$values];
			}
			return $this;
		}

		public function setCaseSensitive($enabled) {
			$this->_function = $enabled ? 'strncmp' : 'strncasecmp';
			return $this;
		}

		/**
		 * @param string $content
		 * @return string|null
		 */
		public function match($content) {
			$_function = $this->_function;
			foreach ($this->_values as $value) {
				$length = strlen($value);
				if ($_function($content, $value, $length) === 0) {
					return substr($content, 0, $length);
				}
			}
			return null;
		}
	}
