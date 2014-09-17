<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class ObjectToIdentifierServicePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('doctrine')) {
            $definition = new DefinitionDecorator('accard.form.type.object_to_identifier');
            $definition->addArgument(new Reference('doctrine'));
            $definition->addArgument('accard_entity_to_identifier');
            $definition->addTag('form.type', array('alias' => 'accard_entity_to_identifier'));

            $container->setDefinition('accard_entity_to_identifier', $definition);
        }

        if ($container->hasDefinition('doctrine_mongodb')) {
            $definition = new DefinitionDecorator('accard.form.type.object_to_identifier');
            $definition->addArgument(new Reference('doctrine_mongodb'));
            $definition->addArgument('accard_document_to_identifier');
            $definition->addTag('form.type', array('alias' => 'accard_document_to_identifier'));

            $container->setDefinition('accard_document_to_identifier', $definition);

            if (!$container->hasDefinition('accard_entity_to_identifier')) {
                $container->setAlias('accard_entity_to_identifier', 'accard_document_to_identifier');
            }
        }

        if ($container->hasDefinition('doctrine_phpcr')) {
            $definition = new DefinitionDecorator('accard.form.type.object_to_identifier');
            $definition->addArgument(new Reference('doctrine_phpcr'));
            $definition->addArgument('accard_phpcr_document_to_identifier');
            $definition->addTag('form.type', array('alias' => 'accard_phpcr_document_to_identifier'));

            $container->setDefinition('accard_phpcr_document_to_identifier', $definition);

            if (!$container->hasDefinition('accard_entity_to_identifier')) {
                $container->setAlias('accard_entity_to_identifier', 'accard_phpcr_document_to_identifier');
            }
        }
    }
}
