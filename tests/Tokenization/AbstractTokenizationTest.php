<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\Tokenizer;
	use \HippoPHP\Tokenizer\Token;

	abstract class AbstractTokenizationTest extends \PHPUnit_Framework_TestCase {
		protected $tokenizer;

		public function setUp() {
			$this->tokenizer = new Tokenizer();
		}

		/**
		 * @param int[] $expectedTokenTypes
		 * @param Token[] $actualTokens
		 * @return void
		 */
		protected function assertTokenTypes(array $expectedTokenTypes, array $actualTokens) {
			$this->_assertTokenField($expectedTokenTypes, $actualTokens, function(Token $token) {
				return $token->getType();
			});
		}

		/**
		 * @param string[] $expectedTokenContent
		 * @param Token[] $actualTokens
		 * @return void
		 */
		protected function assertTokenContent(array $expectedTokenContent, array $actualTokens) {
			$this->_assertTokenField($expectedTokenContent, $actualTokens, function(Token $token) {
				return $token->getContent();
			});
		}

		/**
		 * @param int[] $expectedTokenColumns
		 * @param Token[] $actualTokens
		 * @return void
		 */
		protected function assertTokenColumns(array $expectedTokenColumns, array $actualTokens) {
			$this->_assertTokenField($expectedTokenColumns, $actualTokens, function(Token $token) {
				return $token->getColumn();
			});
		}

		/**
		 * @param int[] $expectedTokenLines
		 * @param Token[] $actualTokens
		 * @return void
		 */
		protected function assertTokenLines(array $expectedTokenLines, array $actualTokens) {
			$this->_assertTokenField($expectedTokenLines, $actualTokens, function(Token $token) {
				return $token->getLine();
			});
		}

		/**
		 * @param mixed[] $expectedFields
		 * @param Token[] $actualTokens
		 * @param callable $getter
		 * @return void
		 */
		private function _assertTokenField(array $expectedFields, array $actualTokens, callable $getter) {
			$this->assertEquals(count($expectedFields), count($actualTokens));
			foreach ($actualTokens as $i => $actualToken) {
				$this->assertEquals($expectedFields[$i], $getter($actualToken));
			}
		}
	}
