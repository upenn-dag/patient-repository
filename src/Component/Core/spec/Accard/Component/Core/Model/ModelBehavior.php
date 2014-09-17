<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace spec\Accard\Component\Core\Model;

use Accard\Component\Resource\Model\User;
use PhpSpec\ObjectBehavior;
use DateTime;

/**
 * Base model object behavior.
 *
 * Extends PhpSpec ObjectBehavior, adding default tests for included traits and
 * other various model-level tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ModelBehavior extends ObjectBehavior
{
    // Versionable

    function it_implements_Accard_versionable_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Model\VersionableInterface');
    }

    function its_current_version_is_zero_by_default()
    {
        $this->getCurrentVersion()->shouldReturn(0);
    }

    function its_current_version_is_mutable()
    {
        $this->setCurrentVersion(1);
        $this->getCurrentVersion()->shouldReturn(1);
    }


    // Timestampable

    function it_implements_Accard_timestampable_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Model\TimestampableInterface');
    }

    function it_sets_creation_date_to_now_by_default()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_creation_date_is_mutable()
    {
        $date = new DateTime();
        $this->setCreatedAt($date);
        $this->getCreatedAt()->shouldReturn($date);
    }

    function it_has_no_update_date_by_default()
    {
        $this->getUpdatedAt()->shouldReturn(null);
    }

    function its_update_date_is_mutable()
    {
        $date = new DateTime();
        $this->setUpdatedAt($date);
        $this->getUpdatedAt()->shouldReturn($date);
    }


    // Blameable

    function it_implements_Accard_blameable_interface()
    {
        $this->shouldImplement('Accard\Component\Resource\Model\BlameableInterface');
    }

    function it_has_no_creation_user_by_default()
    {
        $this->getCreatedBy()->shouldReturn(null);
    }

    function its_creation_user_is_mutable(User $user)
    {
        $this->setCreatedBy($user);
        $this->getCreatedBy()->shouldReturn($user);
    }

    function it_has_no_update_user_by_default()
    {
        $this->getUpdatedBy()->shouldReturn(null);
    }

    function its_update_user_is_mutable(User $user)
    {
        $this->setUpdatedBy($user);
        $this->getUpdatedBy()->shouldReturn($user);
    }
}
