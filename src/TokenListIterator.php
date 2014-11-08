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
				$this->_throwOutOfBoundsException($position);
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
			$_position = $this->_position;

			$this->_move(function() use ($tokenType) {
				!$this->current()->isType($tokenType);
			}, $direction);

			return $this->current();
		}

		/**
		 * Good for ignoring whitespace tokens.
		 * @param array $tokenTypes
		 * @param int $direction DIR_BACKWARD or DIR_FORWARD
		 */
		public function skipTypes($tokenTypes, $direction = self::DIR_FORWARD) {
			$this->_move(function() use ($tokenTypes) {
				return in_array($this->current()->getType(), $tokenTypes);
			}, $direction);

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
			if (!isset($this->_tokens[$this->_position])) {
				$this->_throwOutOfBoundsException();
			}
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
			return $this->validAtPosition($this->_position);
		}

		/**
		 * Checks that a position is valid at a given point.
		 * @param  int $positon
		 * @return bool
		 */
		public function validAtPosition($positon) {
			return isset($this->_tokens[$positon]);
		}

		/**
		 * How many tokens do we have?
		 * @return int
		 */
		public function count() {
			return count($this->_tokens);
		}

		/**
		 * Moves the positon based on a positon.
		 * @param  callable $condition
		 * @param  int   $direction
		 * @return void
		 */
		private function _move(callable $condition, $direction = self::DIR_FORWARD) {
			do {
				if ($direction === self::DIR_FORWARD) {
					$this->next();
				} elseif ($direction === self::DIR_BACKWARD) {
					$this->prev();
				}

				if (!$this->valid()) {
					$this->_throwOutOfBoundsException();
				}
			} while ($condition);
		}

		/**
		 * Throws OutOfBoundsException based on current position within the iterator.
		 * @param int|null $position
		 * @return void
		 */
		private function _throwOutOfBoundsException($position = null) {
			throw new OutOfBoundsException(
				sprintf(
					'Invalid token position (%d)',
					$position !== null ? $position : $this->_position
				)
			);
		}
	}
