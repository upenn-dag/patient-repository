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

use DAG\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;
use Accard\Component\Drug\Model\DrugablePrototypeInterface;

/**
 * Activity prototype interface
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeInterface extends BasePrototypeInterface, DrugablePrototypeInterface
{
}
