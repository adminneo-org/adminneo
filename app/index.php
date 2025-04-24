<?php

use AdminNeo\Pluginer;

function create_adminneo(): Pluginer
{
    // Required to run any plugin.
    include "plugins/Pluginer.php";
    
    // Include plugins.
    include "plugins/dump-xml.php";
    include "plugins/tinymce.php.php";
    include "plugins/file-upload.php";
    
    // Enable plugins.
    $plugins = [
        new XmlDumpPlugin(),
        new TinyMcePlugin(),
        new FileUploadPlugin("data/"),        
    ];
    
    // Define configuration.
    $config = [
        "colorVariant" => "green",
    ];
    
    return new Pluginer($plugins, $config);
}

// Include AdminNeo or EditorNeo.
include "adminneo.php";
