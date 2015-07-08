<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Test\Stub;

use Accard\Component\Resource\Model\ImportTargetInterface;
use Accard\Component\Resource\Model\ImportTargetTrait;

/**
 * Import subject stub.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportTarget implements ImportTargetInterface
{
    use ImportTargetTrait;
}
