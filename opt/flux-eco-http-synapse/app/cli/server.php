<?php
require_once "EnvName.php";
require_once EnvName::FLUX_ECO_HTTP_SYNAPSE_AUTOLOAD_FILE_PATH->toConfigValue();
require_once __DIR__."./../src/Adapters/Api/HttpApi.php";

use FluxEco\IliasUserOrbital\Adapters\Api\HttpApi;
use Swoole\Runtime;
Runtime::enableCoroutine(Runtime::enableCoroutine(SWOOLE_HOOK_NATIVE_CURL));


$server = new Swoole\HTTP\Server('0.0.0.0', EnvName::FLUX_ECO_HTTP_SYNAPSE_PORT->toConfigValue());
$server->set([
    'worker_num' => EnvName::FLUX_ECO_HTTP_SYNAPSE_WORKER_NUM->toConfigValue(),
    // The number of worker processes to start
    'backlog' => EnvName::FLUX_ECO_HTTP_SYNAPSE_BACKLOG->toConfigValue(),
    // TCP backlog connection number
    'daemonize' => false,
    'dispatch_mode' => 2,
    'task_ipc_mode' => 2
]);
/*
$server->set([
    'document_root' => EnvName::SWOOLE_HTTP_OPEN_TCP_NODELAY->toConfigValue(),
    'enable_static_handler' => EnvName::SWOOLE_HTTP_ENABLE_STATIC_FILE_HANDLER->toConfigValue(),
    'static_handler_locations' => explode(" ", EnvName::SWOOLE_HTTP_STATIC_FILE_HANDLER_LOCATIONS->toConfigValue()),
]);*/

$server->on("WorkerStart", function ($server, $workerId) {
    echo "worker started";
});

// Triggered when the HTTP Server starts, connections are accepted after this callback is executed
$server->on("Start", function (Swoole\Http\Server $server) {
    echo "http server started";
});

// The main HTTP server request callback event, entry point for all incoming HTTP requests
$server->on('Request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
    $api = HttpApi::new(call_user_func_array([EnvName::FLUX_ECO_HTTP_SYNAPSE_ORBITAL_API_FQCN->toConfigValue(), "new"], []));
    $api->handleHttpRequest($request, $response);
});

// Triggered when the server is shutting down
$server->on("Shutdown", function ($server, $workerId) {
    echo "http server is shutting down";
});

// Triggered when worker processes are being stopped
$server->on("WorkerStop", function ($server, $workerId) {
    echo "worker processes are being stopped";
});

$server->on('WorkerError', function ($server, $workerId, $workerPid, $exitCode) {
    echo "worker error: " . PHP_EOL;
    echo $exitCode;
});

$server->start();