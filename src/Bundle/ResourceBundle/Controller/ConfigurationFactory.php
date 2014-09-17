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

/**
 * Resource controller configuration factory.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConfigurationFactory
{
    /**
     * Current request.
     *
     * @var ParametersParser
     */
    protected $parametersParser;

    /**
     * Constructor.
     *
     * @param ParametersParser $parametersParser
     */
    public function __construct(ParametersParser $parametersParser)
    {
        $this->parametersParser = $parametersParser;
    }

    /**
     * Create configuration for given parameters.
     *
     * @param string $bundlePrefix
     * @param string $resourceName
     * @param string $templateNamespace
     * @param string $templatingEngine
     *
     * @return Configuration
     */
    public function createConfiguration($bundlePrefix, $resourceName, $templateNamespace, $templatingEngine = 'twig')
    {
        return new Configuration(
            $this->parametersParser,
            $bundlePrefix,
            $resourceName,
            $templateNamespace,
            $templatingEngine
        );
    }
}
