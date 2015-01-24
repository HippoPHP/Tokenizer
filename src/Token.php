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
     * @param mixed $type
     * @param string $content
     * @param int $line
     * @param int $column
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
     * @param  mixes  $tokenTypes
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
}
