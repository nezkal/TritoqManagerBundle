<?php

namespace Tritoq\Bundle\ManagerBoletoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TritoqManagerBoletoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $data['boleto'] = array(
            'tipo' => $config['tipo'],
            'agencia' => $config['agencia'],
            'carteira' => $config['carteira'],
            'conta' => $config['conta'],
            'convenio' => $config['convenio'],
            'dias_prazo' => $config['dias_prazo'],
            'endereco' => $config['endereco'],
            'cidade' => $config['cidade'],
            'uf' => $config['uf'],
            'cnpj' => $config['cnpj'],
            'cedente' => $config['cedente']
        );

        $container->setParameter('tritoq.manager.boleto.configurations', $data);
    }
}
