<?php


namespace GiantQuartz\provider;


use GiantQuartz\provider\tasks\FetchDuePlayersAsyncTask;
use GiantQuartz\provider\tasks\RemoveCommandsAsyncTask;

class BuycraftProvider extends Provider {

    public function fetchCommands(): void {
        $this->scheduleAsyncTask(new FetchDuePlayersAsyncTask($this));
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