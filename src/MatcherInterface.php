<?php

	namespace HippoPHP\Tokenizer;

	interface MatcherInterface {
		/**
		 * @param string $content
		 * @return string[]|null
		 */
		public function match($content);
	}
