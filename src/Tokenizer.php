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

			$tokens = token_get_all($buffer);
			foreach ($tokens as $token) {
				$tokenName = is_array($token) ? $token[0] : null;
				$tokenData = is_array($token) ? $token[1] : $token;
				$tokenLine = is_array($token) ? $token[2] : 0;

				// TODO: Get the column number.
				$tokenList[] = new Token($tokenName, $tokenData, $tokenLine, 0);
			}

			$this->_tokens->setTokens($tokenList);

			return $this->_tokens;
		}

		public function getTokenList() {
			return $this->_tokens;
		}
	}
