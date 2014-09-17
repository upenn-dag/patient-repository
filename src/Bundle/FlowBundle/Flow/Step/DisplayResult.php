<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Step;

use Symfony\Component\HttpFoundation\Response;

/**
 * Display step result.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DisplayResult extends AbstractResult
{
    /**
     * Display response.
     *
     * @var Response
     */
    private $response;


    /**
     * Constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->response;
    }
}
