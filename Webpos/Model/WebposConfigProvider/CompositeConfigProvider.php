<?php

namespace Magestore\Webpos\Model\WebposConfigProvider;
class CompositeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var ConfigProviderInterface[]
     */
    private $configProviders;
    public function __construct(array $configProviders)
    {
        $this->configProviders=$configProviders;
    }

    public function getConfig()
    {
        $config = [];
        foreach ($this->configProviders as $configProvider) {
            $config = array_merge_recursive($config, $configProvider->getConfig());
        }
        return $config;
    }
}