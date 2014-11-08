<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	interface TokenMatcherInterface {
		/**
		 * @return int
		 */
		public function getTokenType();

		/**
		 * @param string $content
		 * @return string|null
		 */
		public function match($content);

		/**
		 * @return int
		 */
		public function getPriority();
	}
