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
 * Code group model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class CodeGroup implements CodeGroupInterface
{
    /**
     * Internal id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Presentation.
     *
     * @var string
     */
    protected $presentation;

    /**
     * Codes.
     *
     * @var Collection|CodeInterface[]
     */
    protected $codes;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->codes = new ArrayCollection();
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCode(CodeInterface $code)
    {
        return $this->codes->contains($code);
    }

    /**
     * {@inheritdoc}
     */
    public function addCode(CodeInterface $code)
    {
        if (!$this->hasCode($code)) {
            $code->addGroup($this);
            $this->codes->add($code);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCode(CodeInterface $code)
    {
        if ($this->hasCode($code)) {
            $this->codes->removeElement($code);
            $code->removeGroup($this);
        }

        return $this;
    }
}
