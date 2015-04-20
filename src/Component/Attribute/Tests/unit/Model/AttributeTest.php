<?php
namespace AccardTest\Component\Attribute\Model;

/**
 * Attribute Model Test
 * 
 * @author Dylan Pierce <dylan@booksmart.it>
 */
use Accard\Component\Attribute\Model\Attribute;

class AttributeTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->attribute = new Attribute();
    }

    protected function _after()
    {
    }

    public function testAttributeFollowsCorrectInterfaces()
    {
        $this->assertInstanceOf('Accard\Component\Attribute\Model\AttributeInterface', $this->attribute);

    }

    public function testAttributeIdIsNullOnCreation()
    {
        $this->assertSame(null, $this->attribute->getId());
    }

    public function testAttributeFieldsAreArrayCollectionOnCreation()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->attribute->getFields());
    }
}