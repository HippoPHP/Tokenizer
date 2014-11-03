<?php

	namespace HippoPHP\Tokenizer;

	class Token {
		/**
		 * Token type.
		 * @var mixed
		 */
		protected $type;

		/**
		 * Token lexme.
		 * @var int
		 */
		protected $lexeme;

		/**
		 * Token line.
		 * @var int
		 */
		protected $line;

		/**
		 * Token column.
		 * @var int
		 */
		protected $column;

		/**
		 * Creates a new Token.
		 * @param mixed $type
		 * @param string $lexeme
		 * @param int $line
		 * @param int $column
		 * @return Token
		 */
		public function __construct($type, $lexeme, $line, $column) {
			$this->type = $type;
			$this->lexeme = $lexeme;
			$this->line = $line;
			$this->column = $column;

			return $this;
		}

		/**
		 * Return the token type.
		 * @return mixed
		 */
		public function getType() {
			return $this->type;
		}

		/**
		 * Return the token lexme.
		 * @return string
		 */
		public function getLexeme() {
			return $this->lexeme;
		}

		/**
		 * Return the token line.
		 * @return int
		 */
		public function getLine() {
			return $this->line;
		}

		/**
		 * Return the token column.
		 * @return int
		 */
		public function getColumn() {
			return $this->column;
		}

		/**
		 * Check if the token contains new line characters.
		 * @return boolean
		 */
		public function hasNewline() {
			if (preg_match('([\r\n])', $this->lexeme)) {
				return true;
			}

			return false;
		}

		/**
		 * Get the number of new lines.
		 * @return int
		 */
		public function getNewlineCount() {
			preg_match_all('(\n|\r\n?)', $this->lexeme, $matches, PREG_SET_ORDER);
			return count($matches);
		}

		/**
		 * Get the length of the last line.
		 * @return int
		 */
		public function getTrailingLineLength() {
			return iconv_strlen(
				substr(strrchr($this->lexeme, "\n") ?: strrchr($this->lexeme, "\r"), 1),
				'utf-8'
			);
		}

		/**
		 * Get length of entire token lexme.
		 * @return int
		 */
		public function getLength() {
			return iconv_strlen($this->lexeme, 'utf-8');
		}
	}
