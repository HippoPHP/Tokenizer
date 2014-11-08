<?php

	namespace HippoPHP\Tokenizer\Tests\Matchers;

	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class RegexMatcherTest extends \PHPUnit_Framework_TestCase {
		public function testBasicString() {
			$regexMatcher = new RegexMatcher('a');
			$this->assertEquals('a', $regexMatcher->match('a'));
			$this->assertEquals('a', $regexMatcher->match('aa'));
			$this->assertEquals('a', $regexMatcher->match('ab'));
			$this->assertNull($regexMatcher->match('b'));
		}

		public function testBasicArray() {
			$regexMatcher = new RegexMatcher(['a', 'b']);
			$this->assertEquals('a', $regexMatcher->match('a'));
			$this->assertEquals('a', $regexMatcher->match('aa'));
			$this->assertEquals('a', $regexMatcher->match('ab'));
			$this->assertEquals('b', $regexMatcher->match('b'));
			$this->assertEquals('b', $regexMatcher->match('ba'));
			$this->assertNull($regexMatcher->match('c'));
		}

		public function testRegex() {
			$regexMatcher = new RegexMatcher('\w+');
			$this->assertEquals('aa', $regexMatcher->match('aa'));
			$this->assertEquals('aa', $regexMatcher->match('aa|'));
			$this->assertNull($regexMatcher->match('|'));
		}

		public function testMultilineRegex() {
			$regexMatcher = new RegexMatcher('.*');
			$this->assertEquals("a\nb", $regexMatcher->match("a\nb"));
		}
	}
