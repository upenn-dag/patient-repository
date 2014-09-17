<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Storage;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

/**
 * Session bag for flows data.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SessionFlowsBag extends NamespacedAttributeBag
{
    const STORAGE_KEY = 'accard.flow.bag';
    const NAME = 'accard.flow.bag';

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(self::STORAGE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
