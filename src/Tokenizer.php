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
			foreach ($this->matchers as $matcher) {
				$tokenType = $matcher->getTokenType();
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
			foreach ($this->_getPathsToTokenMatchers() as $path) {
				require_once $path;
			}


			$this->matchers = [];
			foreach (get_declared_classes() as $class) {
				$reflectionClass = new ReflectionClass($class);
				if ($reflectionClass->implementsInterface('\HippoPHP\Tokenizer\TokenMatchers\TokenMatcherInterface')
						&& !$reflectionClass->isInterface()
						&& !$reflectionClass->isAbstract()) {
					$this->matchers[] = $reflectionClass->newInstance();
				}
			}

			usort($this->matchers, function($a, $b) {
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
