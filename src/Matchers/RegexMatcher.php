<?php

	namespace HippoPHP\Tokenizer\Matchers;

	use \HippoPHP\Tokenizer\Matchers\MatcherInterface;

	class RegexMatcher implements MatcherInterface {
		private $_regexes;
		private $_flags = '';

		public function __construct($regexes) {
			if (is_array($regexes)) {
				$this->_regexes = $regexes;
			} else {
				$this->_regexes = [$regexes];
			}
			return $this;
		}

		/**
		 * Sets whether a regular expression is case sensitive.
		 * @param bool $enabled
		 * @return RegexMatcher
		 */
		public function setCaseSensitive($enabled) {
			$this->_flags = $enabled ? '' : 'i';
			return $this;
		}

		/**
		 * @param string $content
		 * @return string|null
		 */
		public function match($content) {
			foreach ($this->_regexes as $regex) {
				if (preg_match('/^' . $regex . '/ms' . $this->_flags, $content, $matches)) {
					return $matches[0];
				}
			}
			return null;
		}
	}
