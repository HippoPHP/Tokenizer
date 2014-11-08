<?php

	namespace HippoPHP\Tokenizer\Tests\Tokenization;

	use \HippoPHP\Tokenizer\Tests\Tokenization\AbstractTokenizationTest;

	class GeneralTest extends AbstractTokenizationTest {
		public function testNotPhp() {
			$this->setExpectedException('\Exception');
			$this->tokenizer->tokenize('"no token should be matched');
		}
	}
