<?php

namespace Accard\Bridge\Twig\Loader;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Twig_LoaderInterface;
use Twig_Error_Loader;

class TwigAccardFilesystemLoader extends FilesystemLoader
{
    private $defaultLoadBundle;

    public function __construct($defaultLoadBundle,
                                FileLocatorInterface $locator,
                                TemplateNameParserInterface $parser)
    {
        $this->defaultLoadBundle = $defaultLoadBundle;
        parent::__construct($locator, $parser);
    }

    protected function findTemplate($name)
    {
        // If it's prefixed with "Theme" we need to change the name before we pass it along...
        if (TwigDatabaseLoader::MAGIC_TEMPLATE === substr($name, 0, strlen(TwigDatabaseLoader::MAGIC_TEMPLATE))) {
            $name = $this->defaultLoadBundle.substr($name, strlen(TwigDatabaseLoader::MAGIC_TEMPLATE));

            return parent::findTemplate($name);
        }

        throw new Twig_Error_Loader(sprintf('Template for "%s" does not exist and is not prefixed.', $name));        
    }

    protected function getTemplate($base)
    {
        return $this->repository->findOneBy(array(
            'location' => $base,
        ));
    }
}
