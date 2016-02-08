<?php
namespace Framework;

class ConfigurationManager
{
    /**
     * @param string $configurationName
     *
     * @return array
     * @throws \Exception
     */
    static function getConfig($configurationName="parameters")
    {
        $filename = CORE_DIR."../".$configurationName.".json";
        if(!file_exists($filename)) {
            throw new \Exception($filename." : configuration not found");
        }

        $rawConfig = file_get_contents($filename);
        $config = json_decode($rawConfig);

        return $config;
    }
}