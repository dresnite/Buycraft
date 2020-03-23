<?php


namespace GiantQuartz\provider;


use Exception;
use GiantQuartz\provider\tasks\FetchOfflineCommandsAsyncTask;
use GiantQuartz\provider\tasks\FetchQueuedPlayersAsyncTask;
use GiantQuartz\provider\tasks\FetchQueuedPlayerActionsAsyncTask;
use GiantQuartz\provider\tasks\RemoveCommandsAsyncTask;

class BuycraftProvider extends Provider {

    public function fetchOfflineCommands(): void {
        $this->scheduleAsyncTask(new FetchOfflineCommandsAsyncTask($this));
    }

    public function fetchQueuedPlayers(): void {
        $this->scheduleAsyncTask(new FetchQueuedPlayersAsyncTask($this));
    }

    public function fetchQueuedPlayerActions(int $playerId, string $playerName): void {
        $this->scheduleAsyncTask(new FetchQueuedPlayerActionsAsyncTask($this, $playerId, $playerName));
    }

    public function removeCommands(array $identifiers): void {
        $this->scheduleAsyncTask(new RemoveCommandsAsyncTask($this, $identifiers));
    }

    /**
     * @throws Exception
     */
    public function checkSecretKeyValidity(): void {
        $secretKey = $this->getSecretKey();
        if($secretKey == false) {
            $plugin = $this->getPlugin();
            $plugin->getLogger()->error("The secret key is not set, set it in the config file!");
            $plugin->getServer()->getPluginManager()->disablePlugin($plugin);
        }
    }

}