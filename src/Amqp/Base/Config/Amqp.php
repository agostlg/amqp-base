<?php
namespace Amqp\Base\Config;

use Amqp\Base\Config\Interfaces\NamedConfigInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Amqp implements ConfigurationInterface, NamedConfigInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amqp');

        $rootNode
            ->ignoreExtraKeys()
            ->children()
                ->arrayNode('connection')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('host')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->integerNode('port')
                                ->defaultValue(5672)
                            ->end()
                            ->scalarNode('login')
                                ->defaultValue('guest')
                            ->end()
                            ->scalarNode('password')
                                ->defaultValue('guest')
                            ->end()
                            ->scalarNode('vhost')
                                ->defaultValue('/')
                            ->end()
                            ->floatNode('readTimeout')
                                ->defaultValue(0)
                            ->end()
                            ->floatNode('writeTimeout')
                                ->defaultValue(0.2)
                            ->end()
                            ->floatNode('connectTimeout')
                                ->defaultValue(0.2)
                            ->end()
                            ->integerNode('heartbeat')
                                ->defaultValue(10)
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('channel')
                    ->prototype('array')
                        ->children()
                            ->integerNode('count')
                                ->defaultValue(100)
                            ->end()
                            ->integerNode('size')->end()
                            ->booleanNode('transactional')
                                ->defaultFalse()
                            ->end()
                            ->scalarNode('connection')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('exchange')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('dependencies')
                                ->children()
                                    ->arrayNode('exchange')
                                        ->prototype('scalar')->end()
                                    ->end()
                                    ->arrayNode('queue')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('flags')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('channel')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('type')
                                ->cannotBeEmpty()
                            ->end()
                            ->booleanNode('isDefault')->end()
                            ->scalarNode('ae')
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('arguments')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('name')
                                ->children()
                                    ->scalarNode('name')
                                        ->cannotBeEmpty()
                                        ->isRequired()
                                    ->end()
                                    ->scalarNode('class')
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->enumNode('type')
                                        ->values(array('constant', 'static', 'dynamic', 'function'))
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('bindings')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('exchange')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('routingKey')
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->arrayNode('arguments')
                                            ->requiresAtLeastOneElement()
                                            ->prototype('scalar')->end()
                                        ->end()
                                        ->booleanNode('delete')
                                            ->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('queue')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('dependencies')
                                ->children()
                                    ->arrayNode('exchange')
                                        ->prototype('scalar')->end()
                                    ->end()
                                    ->arrayNode('queue')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('channel')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('flags')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('arguments')
                                ->children()
                                    ->integerNode('message_ttl')
                                        //->cannotBeEmpty()
                                    ->end()
                                    ->integerNode('expires')
                                        //->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('dl_exchange')
                                        //->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('dl_routingKey')
                                        //->cannotBeEmpty()
                                    ->end()
                                    ->integerNode('max_length')
                                        //->cannotBeEmpty()
                                    ->end()
                                    ->integerNode('max_bytes')
                                        //->cannotBeEmpty()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('name')
                                ->children()
                                    ->scalarNode('name')
                                        ->cannotBeEmpty()
                                        ->isRequired()
                                    ->end()
                                    ->scalarNode('class')
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->enumNode('type')
                                        ->values(array('constant', 'static', 'dynamic', 'function'))
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('bindings')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('exchange')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('routingKey')
                                            ->isRequired()
                                            ->defaultValue("")
                                        ->end()
                                        ->arrayNode('arguments')
                                            ->requiresAtLeastOneElement()
                                            ->prototype('scalar')->end()
                                        ->end()
                                        ->booleanNode('delete')
                                            ->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'amqp';
    }
}
