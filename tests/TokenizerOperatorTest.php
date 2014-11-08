<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Tokenizer;
	use \HippoPHP\Tokenizer\TokenType;
	use \ReflectionClass;
	use \ReflectionMethod;

	class TokenizerOperatorTest extends \PHPUnit_Framework_TestCase {
		private $tokenizer;

		public function setUp() {
			$this->tokenizer = new Tokenizer;
		}

		public function testGreedyOperatorSequence() {
			$matchers = $this->tokenizer->getMatchers();
			$stringMatcher = $matchers[TokenType::TOKEN_OPERATOR];

			$method = new ReflectionMethod($stringMatcher, 'getValues');
			$tokens = $method->invoke($stringMatcher);

			var_dump($tokens); exit;
		}
	}
