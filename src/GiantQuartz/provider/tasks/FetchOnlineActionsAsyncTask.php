<?php


namespace GiantQuartz\provider\tasks;


use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;

class FetchOnlineActionsAsyncTask extends ProviderAsyncTask {

    /** @var array */
    private $duePlayers;

    public function __construct(Provider $provider, array $duePlayers) {
        $this->duePlayers = $duePlayers;
        parent::__construct($provider);
    }

    public function onRun(): void {
        // TODO: Implement onRun() method.
    }

}