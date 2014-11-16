<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\TokenListIterator;
	use \HippoPHP\Tokenizer\Exception\InvalidArgumentException;

	class Tokenizer {
		/**
		 * @var \HippoPHP\Tokenizer\TokenListIterator
		 */
		private $_tokens;

		/**
		 * Constructor for the Tokenizer.
		 * @return \HippoPHP\Tokenizer\Tokenizer
		 */
		public function __construct() {
			$this->_tokens = new TokenListIterator;
			return $this;
		}

		/**
		 * @param string $buffer
		 * @return array
		 */
		public function tokenize($buffer) {
			if ($buffer === null) {
				return [];
			} elseif (!is_string($buffer)) {
				throw new InvalidArgumentException('Buffer must be a string.');
			}

			$tokenList = [];
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

				$pregMatch = preg_match_all(
					"/(\r\n|\n|\r)/",
					$tokenData,
					$eolMatches,
					\PREG_OFFSET_CAPTURE
				);

				if ($pregMatch) {
					$lineCount = count($eolMatches[0]);
					$lastEolPosition = end($eolMatches[1])[1];
					$lastEolLength = strlen(end($eolMatches[1])[0]);

					$tokenLine += $lineCount;
					$tokenColumn = strlen($tokenData) - ($lastEolPosition + $lastEolLength) + 1;
				} else {
					$tokenColumn += strlen($tokenData);
				}
			}

			$this->_tokens->setTokens($tokenList);

			return $this->_tokens;
		}

		/**
		 * Return the TokenListIterator
		 * @return \HippoPHP\Tokenizer\TokenListIterator
		 */
		public function getTokenList() {
			return $this->_tokens;
		}
	}
