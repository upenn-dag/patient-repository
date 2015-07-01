<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Code model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Code implements CodeInterface
{
    /**
     * Internal id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Code.
     *
     * @var mixed
     */
    protected $code;

    /**
     * Description.
     *
     * @var string
     */
    protected $description;

    /**
     * Groups.
     *
     * @var Collection|CodeGroupInterface[]
     */
    protected $groups;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup(CodeGroupInterface $group)
    {
        return $this->groups->contains($group);
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(CodeGroupInterface $group)
    {
        if (!$this->hasGroup($group)) {
            $this->groups->add($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGroup(CodeGroupInterface $group)
    {
        if ($this->hasGroup($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('DiagnosisCode#%d', $this->id);
    }
}
