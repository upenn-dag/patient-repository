<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Bundle\PatientBundle\Doctrine\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientRepositorySpec extends ObjectBehavior
{
    function let(ObjectManager $manager, ClassMetadata $metadata)
    {
        $metadata->name = 'Accard\Component\Patient\Model\Patient';

        $this->beConstructedWith($manager, $metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Accard\Bundle\PatientBundle\Doctrine\ORM\PatientRepository');
    }

    function it_implements_Accard_repository_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Repository\RepositoryInterface');
    }
}
