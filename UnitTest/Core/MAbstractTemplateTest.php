<?php

namespace MToolkit\Core;

require_once __DIR__ . '/../../Core/MAbstractTemplate.php';

class HelloWorld
{
    const CLASS_NAME = "MToolkit\Core\HelloWorld";

}

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-10-10 at 09:51:40.
 */
class MAbstractTemplateTest extends \PHPUnit_Framework_TestCase
{
    private $mock;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $classname = 'MToolkit\Core\MAbstractTemplate';

        $this->mock = $this->getMockBuilder( $classname )
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

        $this->mock->__construct( HelloWorld::CLASS_NAME );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers MToolkit\Core\MAbstractTemplate::isValidType
     * @todo   Implement testIsValidType().
     */
    public function testIsValidType()
    {
        $this->assertTrue( $this->mock->isValidType( new HelloWorld ) );
    }

    /**
     * @covers MToolkit\Core\MAbstractTemplate::getType
     * @todo   Implement testGetType().
     */
    public function testGetType()
    {
        $this->assertEquals($this->mock->getType(), HelloWorld::CLASS_NAME);
    }

    /**
     * @covers MToolkit\Core\MAbstractTemplate::setType
     * @todo   Implement testSetType().
     */
    public function testSetType()
    {
        $type="test";
        $this->mock->setType( $type );
        $this->assertEquals($this->mock->getType(), $type);
    }
}
