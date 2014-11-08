<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\Tokenizer;
	use \HippoPHP\Tokenizer\TokenType;
	use \ReflectionClass;

	class TokenTypeTest extends \PHPUnit_Framework_TestCase {
		public function testConsts() {
			$consts = $this->_getConsts();
			foreach ($consts as $name => $content) {
				$this->assertEquals($name, $content);
			}
		}

		public function testImplementation() {
			$implemented = [];
			$tokenizer = new Tokenizer();
			foreach ($tokenizer->getMatchers() as $matcher) {
				$implemented[] = $matcher->getTokenType();
			}
			foreach ($this->_getConsts() as $name) {
				$this->assertContains($name, $implemented);
			}
			$this->assertEquals(count($this->_getConsts()), count($implemented));
		}

		private function _getConsts() {
			$reflectionClass = new ReflectionClass('\HippoPHP\Tokenizer\TokenType');
			return $reflectionClass->getConstants();
		}
	}
