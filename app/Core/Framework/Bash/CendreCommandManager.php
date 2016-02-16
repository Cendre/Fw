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

    /**
     * @return string
     */
    public function verifyFolders()
    {
        $folderInspector = new FolderInspector();

        $folders = $folderInspector->verify();

        $return = "";
        $fail = false;
        foreach ($folders as $folderName => $exists) {
            $return .= $folderName." : ";
            if ($exists) {
                $return .= "OK";
            } else {
                $fail = true;
                $return .= "Do not exists";
            }
            $return .= "\n";
        }

        if ($fail) {
            $return .= "Some folder does not exists. To create them, use 'createFolders'";
        }
        
        return $return;
    }

    public function verifyFoldersHelp()
    {
        return "Check if all the folder are okay for the framework to run";
    }
}