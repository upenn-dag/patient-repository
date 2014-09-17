<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Model;

/**
 * Accard attribute model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Attribute implements AttributeInterface
{
    /**
     * Attribute id.
     *
     * @var integer
     */
    protected $id;


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
