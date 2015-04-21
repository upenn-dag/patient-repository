<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace AccardTest\Bundle\ResourceBundle\Controller;

use Mockery;
use Accard\Bundle\ResourceBundle\Controller\ConfigurationFactory;

/**
 * Controller configration factory tests.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ConfigurationFactoryTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $paramHandler = Mockery::mock('Accard\Bundle\ResourceBundle\Controller\ParametersParser');
        $this->configFactory = new ConfigurationFactory($paramHandler);
    }

    public function testConfigurationFactoryCanCreateConfigurations()
    {
        $config = $this->configFactory->createConfiguration('PREFIX', 'RESOURCE', 'TEMPLATE_NAMESPACE', 'ENGINE');
        $this->assertInstanceOf('Accard\Bundle\ResourceBundle\Controller\Configuration', $config);
    }
}
