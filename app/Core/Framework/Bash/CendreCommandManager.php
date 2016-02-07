<?php
namespace Framework\Bash;

use Framework\FolderInspector;

class CendreCommandManager extends AbstractCommandManager {

    const BASH_STRING = ".: Cendre :.  > ";

    /**
     * @desc
     * @return string
     */
    public function pute()
    {
        return "OUI J'SUIS UNE GROSSE PUTE";
    }

    public function verifyFolders()
    {
        $folderInspector = new FolderInspector();

        var_dump($folderInspector->verify());
    }

    public function verifyFoldersHelp()
    {
        return "Check if all the folder are okay for the framework to run";
    }
}