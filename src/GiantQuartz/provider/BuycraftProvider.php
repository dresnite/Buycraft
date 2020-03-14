<?php


namespace GiantQuartz\provider;


use GiantQuartz\provider\tasks\FetchQueuedPlayersAsyncTask;
use GiantQuartz\provider\tasks\FetchQueuedPlayerActions;
use GiantQuartz\provider\tasks\RemoveCommandsAsyncTask;

class BuycraftProvider extends Provider {

    public function fetchQueuedPlayers(): void {
        $this->scheduleAsyncTask(new FetchQueuedPlayersAsyncTask($this));
    }

    public function fetchQueuedPlayerActions(int $playerId): void {
        $this->scheduleAsyncTask(new FetchQueuedPlayerActions($this, $playerId));
    }

    public function removeCommands(array $identifiers): void {
        $this->scheduleAsyncTask(new RemoveCommandsAsyncTask($this, $identifiers));
    }

    public function checkSecretKeyValidity(): void {
        $secretKey = $this->getSecretKey();
        if($secretKey === false) {
            // todo throw exception
        }
    }

}