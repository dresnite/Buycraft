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
    }

    public function getPlugin(): Buycraft {
        return $this->plugin;
    }

    public function getSecretKey(): string {
        return $this->secretKey;
    }

    public abstract function fetchOfflineCommands(): void;

    public abstract function fetchQueuedPlayers(): void;

    public abstract function fetchQueuedPlayerActions(int $playerId, string $playerName): void;

    public abstract function removeCommands(array $identifiers): void;

    protected function scheduleAsyncTask(ProviderAsyncTask $task): void {
        $this->plugin->getServer()->getAsyncPool()->submitTask($task);
    }

}