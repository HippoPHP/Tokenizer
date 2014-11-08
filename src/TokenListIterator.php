<?php

	namespace HippoPHP\Tokenizer;

	use \Countable;
	use \SeekableIterator;
	use \HippoPHP\Tokenizer\Exception\OutOfBoundsException;

	class TokenListIterator implements SeekableIterator, Countable {
		const DIR_FORWARD = 0;
		const DIR_BACKWARD = 1;

		/**
		 * @var int
		 */
		private $_position;

		/**
		 * @var array
		 */
		private $_tokens;

		/**
		 * Tries to go to a position in the stack.
		 * @param  int $position
		 * @return void
		 */
		public function seek($position) {
			if (!isset($this->_tokens[$position])) {
				throw new OutOfBoundsException(
					sprintf('Invalid token position at %d.', $position)
				);
			}

			$this->_position = $position;
		}

		/**
		 * @param Token[] $tokens
		 */
		public function setTokens(array $tokens) {
			$this->_tokens = $tokens;
		}

		/**
		 * @return Token[] $tokens
		 */
		public function getTokens() {
			return $this->_tokens;
		}

		/**
		 * @param string $tokenType
		 * @param int $direction DIR_BACKWARD or DIR_FORWARD
		 */
		public function seekToType($tokenType, $direction = self::DIR_FORWARD) {
			do {
				if ($direction === self::DIR_FORWARD) {
					$this->next();
				} elseif ($direction === self::DIR_BACKWARD) {
					$this->prev();
				}
			} while (!$this->current()->isType($tokenType));

			return $this->current();
		}

		/**
		 * Good for ignoring whitespace tokens.
		 * @param string[] $tokenTypes
		 * @param int $direction DIR_BACKWARD or DIR_FORWARD
		 */
		public function skipTypes($tokenTypes, $direction = self::DIR_FORWARD) {
			do {
				if ($direction === self::DIR_FORWARD) {
					$this->next();
				} elseif ($direction === self::DIR_BACKWARD) {
					$this->prev();
				}
			} while (in_array($this->current()->getType(), $tokenTypes));

			// Move past the current token.
			$this->next();

			return $this->current();
		}

		/**
		 * Returns the current position.
		 * @return int
		 */
		public function key() {
			return $this->_position;
		}

		/**
		 * Sets the next position
		 * @return int
		 */
		public function next() {
			return ++$this->_position;
		}

		/**
		 * Goes back a position.
		 * @return int
		 */
		public function prev() {
			return --$this->_position;
		}

		/**
		 * Returns the current token in the stack.
		 * @return \HippoPHP\Tokenizer\Token
		 */
		public function current() {
			return $this->_tokens[$this->_position];
		}

		/**
		 * Resets the position of the token stack.
		 * @return void
		 */
		public function rewind() {
			$this->_position = 0;
		}

		/**
		 * Checks that the token we're looking for does exist.
		 * @return bool
		 */
		public function valid() {
			return isset($this->_tokens[$this->_position]);
		}

		/**
		 * How many tokens do we have?
		 * @return int
		 */
		public function count() {
			return count($this->_tokens);
		}
	}
