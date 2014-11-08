<?php

	namespace HippoPHP\Tokenizer;

	class RegexMatcher implements MatcherInterface {
		private $_regexes;

		public function __construct($regexes) {
			if (is_array($regexes)) {
				$this->_regexes = $regexes;
			} else {
				$this->_regexes = [$regexes];
			}
		}

		/**
		 * @param string $content
		 * @return string|null
		 */
		public function match($content) {
			foreach ($this->_regexes as $regex) {
				if (preg_match('/^' . $regex . '/ms', $content, $matches)) {
					return $matches[0];
				}
			}
			return null;
		}
	}
