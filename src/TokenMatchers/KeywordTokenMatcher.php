<?php

	namespace HippoPHP\Tokenizer\TokenMatchers;

	use \HippoPHP\Tokenizer\TokenMatchers\AbstractTokenMatcher;
	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;

	class KeywordTokenMatcher extends AbstractTokenMatcher {
		public function getTokenType() {
			return TokenType::TOKEN_KEYWORD;
		}

		public function getMatcher() {
			return (new StringMatcher([
				'__halt_compiler',
				'abstract', 'as', 'break', 'callable', 'case', 'catch',
				'class', 'clone', 'const', 'continue', 'declare',
				'default', 'die', 'do', 'echo', 'else', 'elseif',
				'empty', 'enddeclare', 'endfor', 'endforeach', 'endif',
				'endswitch', 'endwhile', 'eval', 'exit', 'extends',
				'final', 'finally', 'for', 'foreach', 'function',
				'global', 'goto', 'if', 'implements', 'include_once',
				'include', 'insteadof','interface',
				'isset', 'list', 'namespace', 'new', 'or', 'print',
				'private', 'protected', 'public', 'require_once', 'require',
				'return', 'static', 'switch', 'throw', 'trait', 'try',
				'unset', 'use', 'var', 'while', 'yield',
			]))->setCaseSensitive(false);
		}

		public function getPriority() {
			return 90;
		}
	}
