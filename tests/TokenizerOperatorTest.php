<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Tokenizer;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\TokenMatchers\OperatorTokenMatcher;

	class TokenizerOperatorTest extends \PHPUnit_Framework_TestCase {
		public function testGreedyOperatorSequence() {
			$tokenMatcher = new OperatorTokenMatcher;
			$stringMatcher = $tokenMatcher->getMatcher();

			$tokens = $stringMatcher->getValues();
			$tokenCount = count($tokens);

			for ($i = 0; $i < $tokenCount; $i++) {
				for ($j = 0; $j < $i; $j++) {
					$a = $tokens[$i];
					$b = $tokens[$j];

					// If the operators are the same length, ignore it.
					if (strlen($a) === strlen($b)) {
						continue;
					}

					$this->assertFalse($this->startsWith($a, $b));
				}
			}
		}

		private function startsWith($haystack, $needles) {
			foreach ((array) $needles as $needle) {
				if (strncmp($haystack, $needle, strlen($needle)) === 0) {
					return true;
				}
			}

			return false;
		}
	}
