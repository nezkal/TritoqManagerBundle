<?php

namespace Tritoq\Bundle\ManagerBoletoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tritoq_manager_boleto');

        $rootNode->children()
            ->scalarNode('tipo')
            ->end()
            ->scalarNode('cedente')
            ->end()
            ->scalarNode('agencia')
            ->end()
            ->scalarNode('carteira')
            ->end()
            ->scalarNode('conta')
            ->end()
            ->scalarNode('dias_prazo')
            ->end()
            ->scalarNode('convenio')
            ->end()
            ->scalarNode("endereco")
            ->end()
            ->scalarNode("cidade")
            ->end()
            ->scalarNode('cnpj')
            ->end()
            ->scalarNode("uf")
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
