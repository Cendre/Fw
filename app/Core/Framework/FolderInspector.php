<?php
namespace Framework;

class FolderInspector
{
    public function __construct() {

    }

    public function verify() {
        $config = ConfigurationManager::getConfig();
        $folders = $config->folders;

        $foldersCreation = [];
        foreach ($folders as $folder) {
            $foldersCreation[$folder] = is_dir(BASE_DIR.$folder);
        }

        return $foldersCreation;
    }
}
