<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	class Tokenizer {
		private $matchers;

		public function __construct() {
			$this->_buildMatchers();
		}

		public function tokenize($buffer) {
			$currentBuffer = $buffer;
			$tokens = [];
			while ($currentBuffer !== '') {
				$token = $this->_getHeadTokenFromBuffer($currentBuffer);
				if (!$token) {
					throw new \Exception('Syntax error near ' . substr($currentBuffer, 0, 50) . '...');
				}

				$tokens[] = $token;
				if (strlen($token->getContent()) === strlen($currentBuffer)) {
					$currentBuffer = '';
				} else {
					$currentBuffer = substr($currentBuffer, strlen($token->getContent()));
				}
			}
			return $tokens;
		}

		private function _getHeadTokenFromBuffer($currentBuffer) {
			foreach ($this->matchers as $tokenType => $matcher) {
				$content = $matcher->match($currentBuffer);
				if ($content !== null) {
					//TODO: extract line and column
					$token = new Token($tokenType, $content, null, null);
					return $token;
				}
			}
			return null;
		}

		private function _buildMatchers() {
			$this->matchers = [
				TokenType::TOKEN_QUOTED_STRING => new RegexMatcher('(["\'])(?:(?!\1)[^\\\]|\\\.)*\1'),
				TokenType::TOKEN_BIG_COMMENT => new RegexMatcher('\/\*.*\*\/'),
				TokenType::TOKEN_SMALL_COMMENT => new RegexMatcher('\/\/.*$'),
				TokenType::TOKEN_OPEN_TAG => new StringMatcher(['<?php', '<?=', '<?', '<%']),
				TokenType::TOKEN_EOL => new RegexMatcher('[\r\n]+'),
				TokenType::TOKEN_WHITESPACE => new RegexMatcher('[ \t]+'),
				TokenType::TOKEN_CURLY => new StringMatcher(['{', '}']),
				TokenType::TOKEN_ROUND => new StringMatcher(['(', ')']),
				TokenType::TOKEN_SQUARE => new StringMatcher(['[', ']']),
				TokenType::TOKEN_SEMICOLON => new StringMatcher(';'),
				TokenType::TOKEN_COMMA => new StringMatcher(','),
				TokenType::TOKEN_BACKSLASH => new StringMatcher('\\'),
				TokenType::TOKEN_VARIABLE => new RegexMatcher('\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*'),
				TokenType::TOKEN_KEYWORD => (new StringMatcher([
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
				]))->setCaseSensitive(false),

				TokenType::TOKEN_COMPILETIME_CONSTANT => new StringMatcher([
					'__CLASS__',
					'__DIR__',
					'__FILE__',
					'__FUNCTION__',
					'__LINE__',
					'__METHOD__',
					'__NAMESPACE__',
					'__TRAIT__',
				]),

				TokenType::TOKEN_NULL => (new StringMatcher('null'))->setCaseSensitive(false),

				TokenType::TOKEN_BOOLEAN => (new StringMatcher([
					'true',
					'false',
				]))->setCaseSensitive(false),

				TokenType::TOKEN_IDENTIFIER => new RegexMatcher('\w+'),

				TokenType::TOKEN_OPERATOR => new StringMatcher([
					// Scope and classes
					'::', '->',
					// Incrementing
					'++', '+=',
					// Decrementing
					'--', '-=',
					// Arithmetic
					'+', '-', '**', '/', '%', '*', '*=', '/=', '%=', '**=',
					// Assignment
					'=',
					// Bitwise
					'<<', '>>', '&&', '||', '|=', '&=', '<<=', '>>=', '^=',
					'&', '|', '^', '~',
					// Comparison
					'===', '==', '!==', '<>', '!=', '<=', '>=', '<', '>',
					// Logical
					'and', 'or', 'xor', '!',
					// Error Supression
					'@',
					// Ternary
					'?', ':',
					// Concatenation
					'.',
					// Other
					'instanceof',
				]),
			];
		}
	}
