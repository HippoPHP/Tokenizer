<?php

namespace HippoPHP\Tokenizer\tests;

use HippoPHP\Tokenizer\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    protected $token;

    public function setUp()
    {
        $this->token = new Token(T_OPEN_TAG, '<?php', 1, 1);
    }

    public function testGetType()
    {
        $this->assertEquals(T_OPEN_TAG, $this->token->getType());
    }

    public function testToString()
    {
        $this->assertEquals('T_OPEN_TAG('.T_OPEN_TAG.') content: "<?php", line 1, column 1', (string) $this->token);
    }

    public function testGetContent()
    {
        $this->assertEquals('<?php', $this->token->getContent());
    }

    public function testGetLine()
    {
        $this->assertEquals(1, $this->token->getLine());
    }

    public function testGetColumn()
    {
        $this->assertEquals(1, $this->token->getColumn());
    }

    public function testIsKeyword()
    {
        $token = new Token(T_GLOBAL, 'global', 1, 1);

        $this->assertTrue($token->isKeyword());
    }

    public function testIsComment()
    {
        $token = new Token(T_COMMENT, '// Foo, bar, baz', 1, 1);

        $this->assertTrue($token->isComment());
    }

    public function testIsNativeConstant()
    {
        $token = new Token(T_CONST, 'true', 1, 1);

        $this->assertTrue($token->isNativeConstant());
    }
}
