<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\Tokenizer;

	abstract class AbstractTokenizationTest extends \PHPUnit_Framework_TestCase {
		protected $tokenizer;

		public function setUp() {
			$this->tokenizer = new Tokenizer();
		}

		/**
		 * @param int[] $expectedTokenTypes
		 * @param Token[] $actualTokens
		 */
		protected function assertTokenTypes(array $expectedTokenTypes, array $actualTokens) {
			$this->assertEquals(count($expectedTokenTypes), count($actualTokens));
			foreach ($actualTokens as $i => $actualToken) {
				$this->assertEquals($expectedTokenTypes[$i], $actualToken->getType());
			}
		}

		/**
		 * @param string[] $expectedTokenContent
		 * @param Token[] $actualTokens
		 */
		protected function assertTokenContent(array $expectedTokenContent, array $actualTokens) {
			$this->assertEquals(count($expectedTokenContent), count($actualTokens));
			foreach ($actualTokens as $i => $actualToken) {
				$this->assertEquals($expectedTokenContent[$i], $actualToken->getContent());
			}
		}
	}
