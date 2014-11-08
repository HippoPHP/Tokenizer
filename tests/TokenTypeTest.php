<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\TokenType;
	use \ReflectionClass;

	class TokenTypeTest extends \PHPUnit_Framework_TestCase {
		public function testConsts() {
			$reflectionClass = new ReflectionClass('\HippoPHP\Tokenizer\TokenType');
			foreach ($reflectionClass->getConstants() as $name => $content) {
				$this->assertEquals($name, $content);
			}
		}
	}
