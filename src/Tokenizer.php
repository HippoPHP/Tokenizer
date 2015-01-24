<?php

namespace HippoPHP\Tokenizer;

use HippoPHP\Tokenizer\Exception\InvalidArgumentException;

class Tokenizer
{
    /**
     * @param string $buffer
     *
     * @return TokenListIterator
     */
    public static function tokenize($buffer)
    {
        if ($buffer === null) {
            return [];
        } elseif (!is_string($buffer)) {
            throw new InvalidArgumentException('Buffer must be a string.');
        }

        $tokenList = [];
        $tokenLine = 1;
        $tokenColumn = 1;

        foreach (token_get_all($buffer) as $item) {
            list($tokenName, $tokenData) = self::_splitToken($item);

            $tokenList[] = new Token($tokenName, $tokenData, $tokenLine, $tokenColumn);

            $pregMatch = preg_match_all(
                "/(\r\n|\n|\r)/",
                $tokenData,
                $eolMatches,
                \PREG_OFFSET_CAPTURE
            );

            if ($pregMatch) {
                $lineCount = count($eolMatches[0]);
                $lastEolPosition = end($eolMatches[1])[1];
                $lastEolLength = strlen(end($eolMatches[1])[0]);

                $tokenLine += $lineCount;
                $tokenColumn = strlen($tokenData) - ($lastEolPosition + $lastEolLength) + 1;
            } else {
                $tokenColumn += strlen($tokenData);
            }
        }

        return new TokenListIterator($tokenList);
    }

    /**
     * Splits a token into name and data.
     *
     * @param mixed $item
     *
     * @return array
     */
    private static function _splitToken($item)
    {
        if (is_array($item)) {
            $tokenName = $item[0];
            $tokenData = $item[1];
        } else {
            $tokenName = null;
            $tokenData = $item;
        }

        return [$tokenName, $tokenData];
    }
}
