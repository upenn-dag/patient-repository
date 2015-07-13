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

use Accard\Component\Resource\Model\ResourceInterface;
use Accard\Component\Resource\Model\OrderableInterface;
use Accard\Component\Resource\Model\OrderableTrait;

/**
 * Orderable resource stub.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OrderableResource implements ResourceInterface, OrderableInterface
{
    use OrderableTrait;
}
