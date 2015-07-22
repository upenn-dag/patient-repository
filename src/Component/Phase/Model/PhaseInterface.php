<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Phase\Model;

use DateTime;
use DAG\Component\Resource\Model\ResourceInterface;

/**
 * Basic phase interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PhaseInterface extends ResourceInterface
{
    /**
     * Get phase id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get label.
     *
     * @var string $label
     */
    public function getLabel();

    /**
     * Set label.
     *
     * @param string $label
     * @return PhaseInterface
     */
    public function setLabel($label);

    /**
     * Get presentation.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Set presentation.
     *
     * @param string $presentation
     * @return PhaseInterface
     */
    public function setPresentation($presentation);

    /**
     * Get order.
     *
     * @return integer
     */
    public function getOrder();

    /**
     * Set order.
     *
     * @param integer $order
     * @return PhaseInterface
     */
    public function setOrder($order);
}
