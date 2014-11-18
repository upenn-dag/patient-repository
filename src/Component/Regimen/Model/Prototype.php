<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use Accard\Component\Prototype\Model\Prototype as BasePrototype;

/**
 * Regimen prototype model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Prototype extends BasePrototype implements PrototypeInterface
{
    /**
     * Allow drug?
     *
     * @var boolean
     */
    protected $allowDrug = false;


    /**
     * {@inheritdoc}
     */
    public function getAllowDrug()
    {
        return $this->allowDrug;
    }

    /**
     * {@inheritdoc}
     */
    public function setAllowDrug($allowDrug)
    {
        $this->allowDrug = $allowDrug;

        return $this;
    }
}
