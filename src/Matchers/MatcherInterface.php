<?php

	namespace HippoPHP\Tokenizer\Matchers;

	interface MatcherInterface {
		/**
		 * @param string $content
		 * @return string[]|null
		 */
		public function match($content);
	}
