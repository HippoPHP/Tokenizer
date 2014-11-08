<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\TokenMatcherInterface;

	abstract class AbstractTokenMatcher implements TokenMatcherInterface {
		private $_matcher;

		public function __construct() {
			$this->_matcher = $this->getMatcher();
		}

		public function match($text) {
			return $this->_matcher->match($text);
		}

		protected abstract function getMatcher();
	}
