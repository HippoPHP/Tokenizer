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
				TokenType::TOKEN_KEYWORD => new StringMatcher([
					'namespace', 'use',
					'class', 'trait', 'function', 'interface',
					'abstract', 'extends', 'implements', 'new',
					'if', 'else', 'elseif', 'endif',
					'for', 'foreach', 'endfor', 'endforeach',
					'do', 'while',
					'switch', 'case',
					'break', 'continue',
					'return',
					'yield', 'callable',
					'throw', 'try', 'catch', 'finally',
					'public', 'protected', 'private',
					'static', 'final', 'var', 'global',
					'require', 'require_once',
					'include', 'include_once',
					'goto', 'echo',
					'instanceof', 'insteadof',
					'declare', 'enddeclare',
				]),

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

				TokenType::TOKEN_IDENTIFIER => new RegexMatcher('\w+'),
				TokenType::TOKEN_OPERATOR => new StringMatcher([
					'@',
					'&',
					'->', '::',
					'=',
					'|=', '&=', '<<=', '>>=', '+=', '-=', '*=', '/=',
					'!',
					'==', '===', '!=', '!==',
					'<<', '>>',
					'<', '>', '>=', '<=',
					'+', '-', '*', '/',
					'**',
					'?', ':',
					'||', '&&',
					'or', 'and',
					'.',
					'xor',
				]),
			];
		}
	}
