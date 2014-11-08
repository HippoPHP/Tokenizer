<?php

	namespace HippoPHP\Tokenizer\Tests;

	use \HippoPHP\Tokenizer\StringMatcher;

	class StringMatcherTest extends \PHPUnit_Framework_TestCase {
		public function testBasicString() {
			$stringMatcher = new StringMatcher('a');
			$this->assertEquals('a', $stringMatcher->match('a'));
			$this->assertEquals('a', $stringMatcher->match('aa'));
			$this->assertEquals('a', $stringMatcher->match('ab'));
			$this->assertNull($stringMatcher->match('b'));
		}

		public function testBasicArray() {
			$stringMatcher = new StringMatcher(['a', 'b']);
			$this->assertEquals('a', $stringMatcher->match('a'));
			$this->assertEquals('a', $stringMatcher->match('aa'));
			$this->assertEquals('a', $stringMatcher->match('ab'));
			$this->assertEquals('b', $stringMatcher->match('b'));
			$this->assertEquals('b', $stringMatcher->match('ba'));
			$this->assertNull($stringMatcher->match('c'));
		}
	}
