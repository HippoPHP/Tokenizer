<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class GeneralTest extends AbstractTokenizationTest {
		public function testEmptyString() {
			$tokens = $this->tokenizer->tokenize('');
			$this->assertEquals(0, count($tokens));
		}

		public function testNull() {
			$tokens = $this->tokenizer->tokenize(null);
			$this->assertEquals(0, count($tokens));
		}

		public function testNotAString() {
			$this->setExpectedException('\Exception');
			$tokens = $this->tokenizer->tokenize(array());
		}

		public function testNotPhp() {
			$this->setExpectedException('\Exception');
			$this->tokenizer->tokenize('"no token should be matched');
		}

		public function testColumnSingleLine() {
			$tokens = $this->tokenizer->tokenize('"string" . "another"');
			$this->assertTokenColumns([1, 9, 10, 11, 12], $tokens);
			$this->assertTokenLines([1, 1, 1, 1, 1], $tokens);
		}

		public function testColumnMultipleLines() {
			$tokens = $this->tokenizer->tokenize("not\nagain . godzilla");
			$this->assertTokenColumns([1, 4, 1, 6, 7, 8, 9], $tokens);
			$this->assertTokenLines([1, 1, 2, 2, 2, 2, 2], $tokens);
		}
	}
