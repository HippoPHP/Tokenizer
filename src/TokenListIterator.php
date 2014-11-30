<?php

	namespace HippoPHP\Tokenizer;

	use \Countable;
	use \SeekableIterator;
	use \HippoPHP\Tokenizer\Exception\OutOfBoundsException;

	class TokenListIterator implements SeekableIterator, Countable {
		const DIR_FORWARD = 0;
		const DIR_BACKWARD = 1;

		/**
		 * @param Token[] $tokenList
		 */
		public function __construct(array $tokens = []) {
			$this->_tokens = $tokens;
		}

		/**
		 * @var int
		 */
		private $_position = 0;

		/**
		 * @var null|array
		 */
		private $_tokens = null;

		/**
		 * Tries to go to a position in the stack.
		 * @param  int $position
		 * @return void
		 */
		public function seek($position) {
			if (!isset($this->_tokens[$position])) {
				throw $this->_getOutOfBoundsException($position);
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
		 * @param mixed $tokenTypes
		 * @param int $direction DIR_BACKWARD or DIR_FORWARD
		 */
		public function seekToType($tokenTypes, $direction = self::DIR_FORWARD) {
			return $this->_safeMove(function() use ($tokenTypes, $direction) {
				$this->_move($direction);

				$this->_moveWithCondition(function() use ($tokenTypes) {
					return !$this->current()->isType($tokenTypes);
				}, $direction);

				return $this->current();
			});
		}

		/**
		 * Good for ignoring whitespace tokens.
		 * @param array $tokenTypes
		 * @param int $direction DIR_BACKWARD or DIR_FORWARD
		 */
		public function skipTypes($tokenTypes, $direction = self::DIR_FORWARD) {
			return $this->_safeMove(function() use ($tokenTypes, $direction) {
				$this->_moveWithCondition(function() use ($tokenTypes) {
					return in_array($this->current()->getType(), $tokenTypes);
				}, $direction);

				return $this->current();
			});
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
		 * @param int $places
		 * @return TokenListIterator
		 */
		public function &next($places = 1) {
			$this->_position += max(0, $places);
			return $this;
		}

		/**
		 * Goes back a position.
		 * @param int $places
		 * @return TokenListIterator
		 */
		public function &prev($places = 1) {
			$this->_position -= max(0, $places);
			return $this;
		}

		/**
		 * Returns the current token in the stack.
		 * @return \HippoPHP\Tokenizer\Token
		 */
		public function current() {
			if (!isset($this->_tokens[$this->_position])) {
				throw $this->_getOutOfBoundsException();
			}
			return $this->_tokens[$this->_position];
		}

		/**
		 * Resets the position of the token stack.
		 * @return TokenListIterator
		 */
		public function &rewind() {
			$this->_position = 0;
			return $this;
		}

		/**
		 * Moves to the last token
		 * @return TokenListIterator
		 */
		public function &end() {
			$this->_position = count($this->_tokens) - 1;
			return $this;
		}

		/**
		 * Checks that the token we're looking for does exist.
		 * @return bool
		 */
		public function valid() {
			return $this->validAtPosition($this->_position);
		}

		/**
		 * How many tokens do we have?
		 * @return int
		 */
		public function count() {
			return count($this->_tokens);
		}

		/**
		 * Checks that a position is valid at a given point.
		 * @param  int $positon
		 * @return bool
		 */
		private function validAtPosition($positon) {
			return isset($this->_tokens[$positon]);
		}

		/**
		 * Moves the positon based on a direction, until the given condition is fulfilled.
		 * @param  callable $condition
		 * @param  int   $direction
		 * @return void
		 */
		private function _moveWithCondition(callable $condition, $direction = self::DIR_FORWARD) {
			while ($condition()) {
				$this->_move($direction);

				if (!$this->valid()) {
					throw $this->_getOutOfBoundsException();
				}
			}
		}

		/**
		 * Moves the positon based on a direction.
		 * @param  int   $direction
		 * @return void
		 */
		private function _move($direction) {
			if ($direction === self::DIR_FORWARD) {
				$this->next();
			} elseif ($direction === self::DIR_BACKWARD) {
				$this->prev();
			}
		}

		/**
		 * Returns OutOfBoundsException based on current position within the iterator.
		 * @param int|null $position
		 * @return OutOfBoundsException
		 */
		private function _getOutOfBoundsException($position = null) {
			return new OutOfBoundsException(
				sprintf(
					'Invalid token position (%d)',
					$position !== null ? $position : $this->_position
				)
			);
		}

		/**
		 * Restores previous position if OutOfBounds error occurs.
		 * @param callable $moveAction
		 * @return mixed
		 */
		private function _safeMove(callable $moveAction) {
			$oldPosition = $this->_position;
			try {
				return $moveAction();
			} catch (OutOfBoundsException $e) {
				$this->_position = $oldPosition;
				throw $e;
			}
		}
	}
