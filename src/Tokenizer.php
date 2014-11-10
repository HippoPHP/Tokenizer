<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\TokenListIterator;

	class Tokenizer {
		/**
		 * @var TokenListIterator
		 */
		private $_tokens;

		public function __construct() {
			$this->_tokens = new TokenListIterator;
		}

		/**
		 * @param string $buffer
		 * @return array
		 */
		public function tokenize($buffer) {
			if ($buffer === null) {
				return [];
			} elseif (!is_string($buffer)) {
				throw new \Exception('Buffer must be a string.');
			}

			$tokenList = [];
			$parsed = '';
			$tokenLine = 1;
			$tokenColumn = 1;

			foreach (token_get_all($buffer) as $item) {
				if (is_array($item)) {
					$tokenName = $item[0];
					$tokenData = $item[1];
				} else {
					$tokenName = null;
					$tokenData = $item;
				}

				$tokenList[] = new Token($tokenName, $tokenData, $tokenLine, $tokenColumn);

				$parsed .= $tokenData;
				$lineCount = substr_count($parsed, "\n");
				if ($lineCount !== 0) {
					$parsed = substr($parsed, strrpos($parsed, "\n") + 1);
					$tokenLine += $lineCount;
					$tokenColumn = strlen($parsed) + 1;
				} else {
					$tokenColumn += strlen($parsed);
					$parsed = '';
				}
			}

			$this->_tokens->setTokens($tokenList);

			return $this->_tokens;
		}

		public function getTokenList() {
			return $this->_tokens;
		}
	}
