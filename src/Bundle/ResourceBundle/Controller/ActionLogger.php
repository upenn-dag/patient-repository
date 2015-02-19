<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Controller;

use Accard\Component\Resource\Model\UserInterface;

/**
 * Accard resource action logger.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActionLogger
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * Constructor.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config, UserInterface $user)
    {
        $this->config = $config;
        $this->user = $user;
    }

    public function indexLog()
    {
        $request = $this->config->getRequest();

        die(var_dump($this->user));
    }
}
