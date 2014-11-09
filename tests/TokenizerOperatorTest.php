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

					$this->assertFalse($this->startsWith($a, $b), $a . ' is a part of ' . $b);
				}
			}
		}

		private function startsWith($string, $substring) {
			if (strlen($string) < strlen($substring)) {
				return false;
			}
			return strncmp($string, $substring, strlen($substring)) === 0;
		}
	}
