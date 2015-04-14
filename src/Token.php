<?php

namespace HippoPHP\Tokenizer;

class Token
{
    /**
     * Token type.
     *
     * @var string
     */
    private $type;

    /**
     * Token content.
     *
     * @var string
     */
    private $content;

    /**
     * Token line.
     *
     * @var int
     */
    private $line;

    /**
     * Token column.
     *
     * @var int
     */
    private $column;

    /**
     * Creates a new Token.
     *
     * @param mixed  $type
     * @param string $content
     * @param int    $line
     * @param int    $column
     *
     * @return Token
     */
    public function __construct($type, $content, $line, $column)
    {
        $this->type = $type;
        $this->content = $content;
        $this->line = $line;
        $this->column = $column;

        return $this;
    }

    /**
     * Returns the token type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return token string representation. Intended to simplify test debugging.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s(%d) content: "%s", line %d, column %d',
            $this->getTypeName(),
            $this->getType(),
            addslashes($this->getContent()),
            $this->getLine(),
            $this->getColumn()
        );
    }

    /**
     * Return the token content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return the token line.
     *
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Return the token column.
     *
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Compares token types.
     *
     * @param mixed $tokenTypes
     *
     * @return boolean
     */
    public function isType($tokenTypes)
    {
        if (is_array($tokenTypes)) {
            return in_array($this->getType(), $tokenTypes);
        }

        return $this->getType() === $tokenTypes;
    }

    /**
     * Determines whether a token is a comment.
     *
     * @return boolean
     */
    public function isComment()
    {
        static $commentTokens = [T_COMMENT, T_DOC_COMMENT];

        return $this->isType($commentTokens);
    }

    /**
     * Determines whether a token is a native constant.
     *
     * @return boolean
     */
    public function isNativeConstant()
    {
        static $nativeConstantStrings = ['true', 'false', 'null'];

        return in_array(strtolower($this->content), $nativeConstantStrings, true);
    }

    /**
     * Determines whether a token is a keyword.
     *
     * @return boolean
     */
    public function isKeyword()
    {
        $keywords = static::getKeywords();

        return isset($keywords[$this->type]);
    }

    /**
     * Returns name of the token type.
     * Shouldn't be used outside debugging purposes.
     *
     * @return string
     */
    protected function getTypeName()
    {
        $result = $this->type;
        foreach (get_defined_constants() as $name => $value) {
            if (substr($name, 0, 2) === 'T_' && $value === $this->type) {
                $result = $name;
                break;
            }
        }

        return $result;
    }

    /**
     * Generate keywords array contains all keywords that exists in used PHP version.
     *
     * @return array
     */
    public static function getKeywords()
    {
        static $keywords = null;

        if ($keywords === null) {
            $keywords = [];

            $keywordsStrings = [
                'T_ABSTRACT', 'T_ARRAY', 'T_AS', 'T_BREAK', 'T_CALLABLE', 'T_CASE',
                'T_CATCH', 'T_CLASS', 'T_CLONE', 'T_CONST', 'T_CONTINUE', 'T_DECLARE', 'T_DEFAULT', 'T_DO',
                'T_ECHO', 'T_ELSE', 'T_ELSEIF', 'T_EMPTY', 'T_ENDDECLARE', 'T_ENDFOR', 'T_ENDFOREACH',
                'T_ENDIF', 'T_ENDSWITCH', 'T_ENDWHILE', 'T_EVAL', 'T_EXIT', 'T_EXTENDS', 'T_FINAL',
                'T_FINALLY', 'T_FOR', 'T_FOREACH', 'T_FUNCTION', 'T_GLOBAL', 'T_GOTO', 'T_HALT_COMPILER',
                'T_IF', 'T_IMPLEMENTS', 'T_INCLUDE', 'T_INCLUDE_ONCE', 'T_INSTANCEOF', 'T_INSTEADOF',
                'T_INTERFACE', 'T_ISSET', 'T_LIST', 'T_LOGICAL_AND', 'T_LOGICAL_OR', 'T_LOGICAL_XOR',
                'T_NAMESPACE', 'T_NEW', 'T_PRINT', 'T_PRIVATE', 'T_PROTECTED', 'T_PUBLIC', 'T_REQUIRE',
                'T_REQUIRE_ONCE', 'T_RETURN', 'T_STATIC', 'T_SWITCH', 'T_THROW', 'T_TRAIT', 'T_TRY',
                'T_UNSET', 'T_USE', 'T_VAR', 'T_WHILE', 'T_YIELD',
            ];

            foreach ($keywordsStrings as $keywordName) {
                if (defined($keywordName)) {
                    $keyword = constant($keywordName);
                    $keywords[$keyword] = $keyword;
                }
            }
        }

        return $keywords;
    }
}
