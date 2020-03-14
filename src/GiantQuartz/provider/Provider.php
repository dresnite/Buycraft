<?php


namespace GiantQuartz\provider;


use GiantQuartz\Buycraft;

abstract class Provider {

    /** @var Buycraft */
    private $plugin;

    /** @var string */
    private $secretKey;

    public function __construct(Buycraft $plugin) {
        $this->plugin = $plugin;
        $this->secretKey = $plugin->getConfig()->get("secret-key");
        $this->checkSecretKeyValidity();
    }

    /**
     * @return string
     */
    public function getSecretKey(): string {
        return $this->secretKey;
    }

    public abstract function fetchQueuedPlayers(): void;

    public abstract function fetchActions(array $players): void;

    public abstract function removeCommands(array $identifiers): void;

    public abstract function checkSecretKeyValidity(): void;

    protected function scheduleAsyncTask(ProviderAsyncTask $task): void {
        $this->plugin->getServer()->getAsyncPool()->submitTask($task);
    }

}