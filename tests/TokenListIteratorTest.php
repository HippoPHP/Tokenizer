<?php

namespace HippoPHP\Tokenizer\tests;

use HippoPHP\Tokenizer\Token;
use HippoPHP\Tokenizer\TokenListIterator;

class TokenListIteratorTest extends \PHPUnit_Framework_TestCase
{
    protected $tokenList;
    protected $tokens;

    public function setUp()
    {
        $this->tokenList = new TokenListIterator();

        // Make some tokens.
        $this->tokens = [
            new Token(T_OPEN_TAG, '<?php', 1, 1),
            new Token(T_WHITESPACE, "\t", 2, 1),
            new Token(T_VARIABLE, '$var', 2, 2),
        ];

        $this->tokenList->setTokens($this->tokens);
    }

    public function testGetTokens()
    {
        $this->assertSame($this->tokens, $this->tokenList->getTokens());
    }

    public function testGetCount()
    {
        $this->assertEquals(count($this->tokens), $this->tokenList->count());
    }

    /**
     * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
     */
    public function testSeekOutOfRange()
    {
        $this->tokenList->seek(999);
    }

    public function testSeekValid()
    {
        $this->tokenList->seek(1);
        $this->assertEquals(1, $this->tokenList->key());
    }

    public function testRewind()
    {
        $this->tokenList->next();
        $this->tokenList->rewind();
        $this->assertEquals(0, $this->tokenList->key());
    }

    public function testMoveAround()
    {
        $this->tokenList->next();
        $this->assertEquals(1, $this->tokenList->key());
        $this->tokenList->prev();
        $this->assertEquals(0, $this->tokenList->key());
    }

    /**
     * @expectedException \HippoPHP\Tokenizer\Exception\InvalidArgumentException
     */
    public function testMoveAroundInvalid()
    {
        $this->tokenList->move(3);
    }

    public function testIsValid()
    {
        $this->assertTrue($this->tokenList->valid());
        $this->tokenList->seek(count($this->tokenList) - 1);
        $this->tokenList->next();
        $this->assertFalse($this->tokenList->valid());
    }

    /**
     * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
     */
    public function testGetInvalid()
    {
        $this->tokenList->seek(count($this->tokenList) - 1);
        $this->tokenList->next();
        $this->tokenList->current();
    }

    public function testSeekToType()
    {
        $seekToken = new Token(T_WHITESPACE, "\t", 2, 1);
        $this->assertEquals($seekToken, $this->tokenList->seekToType(T_WHITESPACE)->current());
    }

    public function testSeekToTypeArray()
    {
        $seekToken = new Token(T_WHITESPACE, "\t", 2, 1);
        $this->assertEquals($seekToken, $this->tokenList->seekToType([T_WHITESPACE])->current());
    }

    public function testSeekBackwards()
    {
        $this->tokenList->seek(2);
        $actualToken = $this->tokenList->seekToType(T_WHITESPACE, TokenListIterator::DIR_BACKWARD)->current();
        $this->assertNotNull($actualToken);
        $this->assertEquals(T_WHITESPACE, $actualToken->getType());
    }

    /**
     * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
     */
    public function testSeekToNonExistingType()
    {
        $this->tokenList->seekToType(T_OPEN_TAG);
    }

    /**
     * @expectedException \HippoPHP\Tokenizer\Exception\OutOfBoundsException
     */
    public function testSeekToNonExistingTypeReset()
    {
        try {
            $this->tokenList->seekToType(T_OPEN_TAG);
        } catch (\Exception $e) {
            $this->assertEquals(0, $this->tokenList->key());
            throw $e;
        }
    }

    public function testSkipTypes()
    {
        $ignoreTokens = [
            T_OPEN_TAG,
            T_WHITESPACE,
        ];

        $expectedToken = new Token(T_VARIABLE, '$var', 2, 2);
        $this->assertEquals($expectedToken, $this->tokenList->skipTypes($ignoreTokens)->current());
    }

    public function testSkipNonexistingTypes()
    {
        $actualToken = $this->tokenList->skipTypes([T_OPEN_TAG])->current();
        $this->assertNotNull($actualToken);
        $this->assertEquals(T_WHITESPACE, $actualToken->getType());
    }

    public function testSkipToNextNonWhitespace()
    {
        $actualToken = $this->tokenList->skipToNextNonWhitespace()->current();
        $this->assertNotNull($actualToken);
        $this->assertEquals(T_VARIABLE, $actualToken->getType());
    }

    public function testEndMethod()
    {
        // Move to beginning
        $this->tokenList->rewind();
        // Move to the end
        $this->tokenList->end();

        $this->assertEquals(T_VARIABLE, $this->tokenList->current()->getType());
    }

    public function testNextPlaces()
    {
        $this->tokenList->rewind();
        $this->tokenList->next(2);
        $this->assertEquals(T_VARIABLE, $this->tokenList->current()->getType());
    }

    public function testPrevPlaces()
    {
        $this->tokenList->end();
        $this->tokenList->prev(2);
        $this->assertEquals(T_OPEN_TAG, $this->tokenList->current()->getType());
    }
}
