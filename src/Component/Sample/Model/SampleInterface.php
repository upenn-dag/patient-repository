<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Model;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;
use Accard\Component\Field\Model\FieldSubjectInterface;

/**
 * Basic sample interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SampleInterface extends PrototypeSubjectInterface, FieldSubjectInterface
{
    /**
     * Get sample id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get source.
     *
     * @var SourceInterface
     */
    public function getSource();

    /**
     * Set source.
     *
     * @param SourceInterface $source
     * @return SampleInterface
     */
    public function setSource(SourceInterface $source = null);

    /**
     * Get amount.
     *
     * @return integer
     */
    public function getAmount();

    /**
     * Set amount.
     *
     * @param integer $amount
     * @return SampleInterface
     */
    public function setAmount($amount);

    /**
     * Get derivatives.
     *
     * @return Collection|SourceInterface[]
     */
    public function getDerivatives();

    /**
     * Test for presence of derivative.
     *
     * @param SourceInterface $derivation
     * @return boolean
     */
    public function hasDerivative(SourceInterface $derivation);

    /**
     * Test for presence of any derivatives.
     *
     * @return boolean
     */
    public function hasDerivatives();

    /**
     * Add derivative.
     *
     * @param SourceInterface $derivation
     * @return SampleInterface
     */
    public function addDerivative(SourceInterface $derivative);

    /**
     * Remove derivative.
     *
     * @param SourceInterface $derivation
     * @return SampleInterface
     */
    public function removeDerivative(SourceInterface $derivative);
}
