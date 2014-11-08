<?php

	namespace HippoPHP\Tokenizer;

	class TokenType {
		const TOKEN_OPEN_TAG = 'TOKEN_OPEN_TAG';
		const TOKEN_WHITESPACE = 'TOKEN_WHITESPACE';
		const TOKEN_EOL = 'TOKEN_EOL';
		const TOKEN_CURLY = 'TOKEN_CURLY';
		const TOKEN_ROUND = 'TOKEN_ROUND';
		const TOKEN_SQUARE = 'TOKEN_SQUARE';
		const TOKEN_SEMICOLON = 'TOKEN_SEMICOLON';
		const TOKEN_COMMA = 'TOKEN_COMMA';
		const TOKEN_BACKSLASH = 'TOKEN_BACKSLASH';
		const TOKEN_IDENTIFIER = 'TOKEN_IDENTIFIER';
		const TOKEN_VARIABLE = 'TOKEN_VARIABLE';
		const TOKEN_QUOTED_STRING = 'TOKEN_QUOTED_STRING';
		const TOKEN_KEYWORD = 'TOKEN_KEYWORD';
		const TOKEN_OPERATOR = 'TOKEN_OPERATOR';
		const TOKEN_BIG_COMMENT = 'TOKEN_BIG_COMMENT';
		const TOKEN_SMALL_COMMENT = 'TOKEN_SMALL_COMMENT';
		const TOKEN_COMPILETIME_CONSTANTS = 'TOKEN_COMPILETIME_CONSTANTS';
	}
