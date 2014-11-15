<?php

	namespace HippoPHP\Tokenizer;

	use \HippoPHP\Tokenizer\Token;
	use \HippoPHP\Tokenizer\TokenListIterator;
	use \HippoPHP\Tokenizer\Exception\InvalidArgumentException;

	class Tokenizer {
		/**
		 * @var TokenListIterator
		 */
		private $_tokens;

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
				if (preg_match_all("/(\r\n|\n|\r)/", $parsed, $eolMatches, \PREG_OFFSET_CAPTURE))
				{
					$lineCount = count($eolMatches[0]);
					$lastEolPosition = end($eolMatches[1])[1];
					$lastEolLength = strlen(end($eolMatches[1])[0]);

					$parsed = substr($parsed, $lastEolPosition + $lastEolLength);
					$tokenLine += $lineCount;
					$tokenColumn = strlen($parsed) + 1;
					$parsed = '';
				} else {
					$tokenColumn += strlen($parsed);
					$parsed = '';
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
