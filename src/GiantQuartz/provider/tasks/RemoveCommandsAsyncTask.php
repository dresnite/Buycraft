<?php


namespace GiantQuartz\provider\tasks;


use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;

class RemoveCommandsAsyncTask extends ProviderAsyncTask {

    /** @var array */
    private $commands;

    public function __construct(Provider $provider, array $commands) {
        $this->commands = $commands;
        parent::__construct($provider);
    }

    public function onRun(): void {
        // TODO: Implement onRun() method.
    }

}