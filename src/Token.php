<?php

	namespace HippoPHP\Tokenizer;

	class Token {
		/**
		 * Token type.
		 * @var string
		 */
		protected $type;

		/**
		 * Token content.
		 * @var string
		 */
		protected $content;

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
		 * @param string $content
		 * @param int $line
		 * @param int $column
		 * @return Token
		 */
		public function __construct($type, $content, $line, $column) {
			$this->type = $type;
			$this->content = $content;
			$this->line = $line;
			$this->column = $column;
		}

		/**
		 * Return the token type.
		 * @return string
		 */
		public function getType() {
			return $this->type;
		}

		/**
		 * Return the token content.
		 * @return string
		 */
		public function getContent() {
			return $this->content;
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
	}
