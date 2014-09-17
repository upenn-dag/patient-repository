<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Templating\Helper;

use InvalidArgumentException;
use Accard\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use Symfony\Component\Templating\Helper\Helper;

/**
 * Settings template helper.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SettingsHelper extends Helper
{
    /**
     * Settings manager.
     *
     * @var SettingsManagerInterface
     */
    private $settingsManager;


    /**
     * Constructor.
     *
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * Get settings within a namespace.
     *
     * @param string $namespace
     * @return Collection
     */
    public function getSettings($namespace)
    {
        return $this->settingsManager->load($namespace);
    }

    /**
     * Get settings parameter within a namespace by name.
     *
     * Use dot notation. ie. "global_settings.name".
     *
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException if argument is not in dot notation format.
     */
    public function getParameter($name)
    {
        if (false === strpos($name, '.')) {
            throw new InvalidArgumentException('Parameter must use dot notation, %s given.', $name);
        }

        list($namespace, $name) = explode('.', $name);
        $settings = $this->settingsManager->load($namespace);

        return $settings->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_settings';
    }
}
