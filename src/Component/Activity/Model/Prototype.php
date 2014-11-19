<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use Accard\Component\Prototype\Model\Prototype as BasePrototype;
use Accard\Component\Drug\Model\DrugablePrototypeTrait;

/**
 * Activity prototype model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Prototype extends BasePrototype implements PrototypeInterface
{
    use DrugablePrototypeTrait;
}
