<?php

namespace HippoPHP\Tokenizer;

use Countable;
use HippoPHP\Tokenizer\Exception\OutOfBoundsException;
use SeekableIterator;

class TokenListIterator implements SeekableIterator, Countable
{
    const DIR_FORWARD = 0;
    const DIR_BACKWARD = 1;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var null|\HippoPHP\Tokenizer\Token[]
     */
    private $tokens = null;

    /**
     * @param \HippoPHP\Tokenizer\Token[] $tokenList
     */
    public function __construct(array $tokens = [])
    {
        $this->tokens = $tokens;
    }

    /**
     * Tries to go to a position in the stack.
     *
     * @param int $position
     *
     * @return void
     */
    public function seek($position)
    {
        if (!isset($this->tokens[$position])) {
            throw $this->getOutOfBoundsException($position);
        }

        $this->position = $position;
    }

    /**
     * @param \HippoPHP\Tokenizer\Token[] $tokens
     */
    public function setTokens(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return \HippoPHP\Tokenizer\Token[] $tokens
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param mixed $tokenTypes
     * @param int   $direction  DIR_BACKWARD or DIR_FORWARD
     *
     * @return mixed
     */
    public function seekToType($tokenTypes, $direction = self::DIR_FORWARD)
    {
        return $this->safeMove(function () use ($tokenTypes, $direction) {
            $this->move($direction);

            $this->moveWithCondition(function () use ($tokenTypes) {
                return !$this->current()->isType($tokenTypes);
            }, $direction);

            return $this->current();
        });
    }

    /**
     * Traverse the token tree passing any ignored types.
     *
     * @param array $tokenTypes
     * @param int   $direction  DIR_BACKWARD or DIR_FORWARD
     *
     * @return mixed
     */
    public function skipTypes($tokenTypes, $direction = self::DIR_FORWARD)
    {
        return $this->safeMove(function () use ($tokenTypes, $direction) {
            $this->moveWithCondition(function () use ($tokenTypes) {
                return in_array($this->current()->getType(), $tokenTypes);
            }, $direction);

            return $this->current();
        });
    }

    /**
     * Returns the current position.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Sets the next position.
     *
     * @param int $places
     *
     * @return TokenListIterator
     */
    public function &next($places = 1)
    {
        $this->position += max(0, $places);

        return $this;
    }

    /**
     * Goes back a position.
     *
     * @param int $places
     *
     * @return TokenListIterator
     */
    public function &prev($places = 1)
    {
        $this->position -= max(0, $places);

        return $this;
    }

    /**
     * Returns the current token in the stack.
     *
     * @return \HippoPHP\Tokenizer\Token
     */
    public function current()
    {
        if (!isset($this->tokens[$this->position])) {
            throw $this->getOutOfBoundsException();
        }

        return $this->tokens[$this->position];
    }

    /**
     * Resets the position of the token stack.
     *
     * @return TokenListIterator
     */
    public function &rewind()
    {
        $this->position = 0;

        return $this;
    }

    /**
     * Moves to the last token.
     *
     * @return TokenListIterator
     */
    public function &end()
    {
        $this->position = count($this->tokens) - 1;

        return $this;
    }

    /**
     * Checks that the token we're looking for does exist.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->validAtPosition($this->position);
    }

    /**
     * How many tokens do we have?
     *
     * @return int
     */
    public function count()
    {
        return count($this->tokens);
    }

    /**
     * Checks that a position is valid at a given point.
     *
     * @param int $positon
     *
     * @return bool
     */
    private function validAtPosition($positon)
    {
        return isset($this->tokens[$positon]);
    }

    /**
     * Moves the positon based on a direction, until the given condition is fulfilled.
     *
     * @param callable $condition
     * @param int      $direction
     *
     * @return void
     */
    private function moveWithCondition(callable $condition, $direction = self::DIR_FORWARD)
    {
        while ($condition()) {
            $this->move($direction);

            if (!$this->valid()) {
                throw $this->getOutOfBoundsException();
            }
        }
    }

    /**
     * Moves the positon based on a direction.
     *
     * @param int $direction
     *
     * @return void
     */
    private function move($direction)
    {
        if ($direction === self::DIR_FORWARD) {
            $this->next();
        } elseif ($direction === self::DIR_BACKWARD) {
            $this->prev();
        }
    }

    /**
     * Returns OutOfBoundsException based on current position within the iterator.
     *
     * @param int|null $position
     *
     * @return \HippoPHP\Tokenizer\Exception\OutOfBoundsException
     */
    private function getOutOfBoundsException($position = null)
    {
        return new OutOfBoundsException(
            sprintf(
                'Invalid token position (%d)',
                $position !== null ? $position : $this->position
            )
        );
    }

    /**
     * Restores previous position if OutOfBounds error occurs.
     *
     * @param callable $moveAction
     *
     * @return mixed
     */
    private function safeMove(callable $moveAction)
    {
        $oldPosition = $this->position;
        try {
            return $moveAction();
        } catch (OutOfBoundsException $e) {
            $this->position = $oldPosition;
            throw $e;
        }
    }
}
