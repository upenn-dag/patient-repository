<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Bundle\AttributeBundle\Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectAttribute;
use Prophecy\Argument;

/**
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class AttributeRepositorySpec extends ObjectAttribute
{
    function let(ObjectManager $manager, ClassMetadata $metadata)
    {
        $metadata->name = 'Accard\Component\Attribute\Model\Attribute';

        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\AttributeBundle\Doctrine\ORM\AttributeRepository');
    }

    function it_implements_Accard_repository_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Repository\RepositoryInterface');
    }
}
