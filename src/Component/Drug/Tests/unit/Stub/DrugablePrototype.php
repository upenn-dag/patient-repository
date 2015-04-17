<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Stub;

use Accard\Component\Drug\Model\DrugablePrototypeTrait;
use Accard\Component\Drug\Model\DrugablePrototypeInterface;

/**
 * Accard drugable prototype stub.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DrugablePrototype implements DrugablePrototypeInterface
{
    use DrugablePrototypeTrait;

    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
    }
}