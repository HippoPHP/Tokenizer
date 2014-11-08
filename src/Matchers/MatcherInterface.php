<?php

	namespace HippoPHP\Tokenizer\Matchers;

	interface MatcherInterface {
		/**
		 * @param string $content
		 * @return string[]|null
		 */
		public function match($content);

		/**
		 * @param bool $enabled
		 * @return $this
		 */
		public function setCaseSensitive($enabled);
	}
