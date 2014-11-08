<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\TokenType;
	use \HippoPHP\Tokenizer\Matchers\StringMatcher;
	use \HippoPHP\Tokenizer\Matchers\RegexMatcher;

	use \RecursiveDirectoryIterator;
	use \RecursiveIteratorIterator;
	use \RegexIterator;
	use \ReflectionClass;

	class Tokenizer {
		private $_matchers;

		public function __construct() {
			$this->_buildMatchers();
		}

		public function tokenize($buffer) {
			$currentBuffer = $buffer;
			$tokens = [];

			$column = 1;
			$line = 1;

			while ($currentBuffer !== '') {
				$token = $this->_getHeadTokenFromBuffer($currentBuffer, $line, $column);
				if (!$token) {
					throw new \Exception('Syntax error near ' . substr($currentBuffer, 0, 50) . '...');
				}

				$tokens[] = $token;
				$tokenLength = strlen($token->getContent());

				if ($token->getType() === TokenType::TOKEN_EOL) {
					$line ++;
					$column = 1;
				} else {
					$column += $tokenLength;
				}

				if ($tokenLength === strlen($currentBuffer)) {
					$currentBuffer = '';
				} else {
					$currentBuffer = substr($currentBuffer, $tokenLength);
				}
			}
			return $tokens;
		}

		/**
		 * @return TokenMatcher[]
		 */
		public function getMatchers() {
			return $this->_matchers;
		}

		private function _getHeadTokenFromBuffer($currentBuffer, $currentLine, $currentColumn) {
			foreach ($this->_matchers as $matcher) {
				$tokenType = $matcher->getTokenType();
				$content = $matcher->match($currentBuffer);
				if ($content !== null) {
					//TODO: extract line and column
					$token = new Token($tokenType, $content, $currentLine, $currentColumn);
					return $token;
				}
			}
			return null;
		}

		private function _buildMatchers() {
			foreach ($this->_getPathsToTokenMatchers() as $path) {
				require_once $path;
			}

			$this->_matchers = [];
			foreach (get_declared_classes() as $class) {
				$reflectionClass = new ReflectionClass($class);
				if ($reflectionClass->implementsInterface('\HippoPHP\Tokenizer\TokenMatchers\TokenMatcherInterface')
						&& !$reflectionClass->isInterface()
						&& !$reflectionClass->isAbstract()) {
					$this->_matchers[] = $reflectionClass->newInstance();
				}
			}

			usort($this->_matchers, function($a, $b) {
				return $b->getPriority() - $a->getPriority();
			});
		}

		private function _getPathsToTokenMatchers() {
			return
				new RegexIterator(
					new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator(
							__DIR__ . DIRECTORY_SEPARATOR . 'TokenMatchers',
							RecursiveDirectoryIterator::SKIP_DOTS)),
					'/php$/i');
		}
	}
