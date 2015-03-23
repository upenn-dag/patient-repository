<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bridge\Twig\Loader;

use Twig_LoaderInterface;
use Twig_Error_Loader;
use Accard\Bundle\TemplateBundle\Doctrine\ORM\TemplateRepository;

/**
 * Twig Database Loader
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class TwigDatabaseLoader implements Twig_LoaderInterface
{
    /**
     *
     */
    const MAGIC_TEMPLATE = 'Theme';
    const MAGIC_PREFIX = 'Accard';

    /**
     * Template repository.
     * 
     * @var TemplateRepository
     */
    private $repository;

    /**
     * Constructor.
     * 
     * @param TemplateRepository
     */
    public function __construct($repository)
    {
        $this->repository= $repository;
    }

    /**
     * Get Source
     *
     * @var string $name
     * @return string
     * @throws Twig_Error_Loader
     */
    public function getSource($name)
    {
        // If we aren't using Symfony style loading, ignore this loader.
        // $themedLocation = sprintf('%s:%s:%s', self::MAGIC_TEMPLATE, $parts[1], $parts[2]);
        $parts = explode(':', $name);

        if (3 === count($parts) && self::MAGIC_TEMPLATE === $parts[0]) {
            $baseName = sprintf('%s:%s', $parts[1], $parts[2]);
            $themeName = sprintf('%s:%s:%s', self::MAGIC_TEMPLATE, $parts[1], $parts[2]);

            if ($template = $this->getTemplate($themeName)) {
                $content = $template->getContent();

                return $content;
            }
        }

        throw new Twig_Error_Loader(sprintf('Template for "%s" does not exist.', $name));
    }

    public function isFresh($name, $time)
    {
        return false;
    }

    public function getCacheKey($name)
    {
        return 'AccardDB:' . $name;
    }

    protected function getTemplate($base)
    {
        return $this->repository->findOneBy(array(
            'location' => $base,
        ));
    }

    protected function getValue($column, $name)
    {
        return $this->repository->findOneBy(array($column => $name));
    }
}