<?php

spl_autoload_register(function (string $class) {
    $namespace = "FluxEco\\DispatcherSynapse";
    $baseDirectory = '/opt/flux-eco-dispatcher-synapse/app/src';
    loadClassFileDispatcherSynapse($namespace, $class, $baseDirectory);
});

/**
 * @param string $namespace
 * @param string $class
 * @param string $baseDirectory
 * @return void
 */
function loadClassFileDispatcherSynapse(string $namespace, string $class, string $baseDirectory) : void
{
    $classNameParts = explode($namespace, $class);
    // not our responsibility
    if (count($classNameParts) !== 2) {
        return;
    }
    $filePath = str_replace('\\', '/', $classNameParts[1]) . '.php';
    require $baseDirectory . $filePath;
}