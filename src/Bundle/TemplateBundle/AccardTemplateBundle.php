<?php

namespace Accard\Bundle\TemplateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Accard\Bundle\TemplateBundle\DependencyInjection\Compiler\TwigDatabaseLoaderPass;

class AccardTemplateBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwigDatabaseLoaderPass());
    }
}
