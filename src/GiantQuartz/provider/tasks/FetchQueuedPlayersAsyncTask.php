<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\ProviderAsyncTask;

class FetchQueuedPlayersAsyncTask extends ProviderAsyncTask {

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $this->executeCurl($this->getCurlSession());
    }

    /**
     * @throws Exception
     */
    public function onCompletion(): void {
        $plugin = $this->getBuycraft();
        $result = $this->getResult();

        $queuedPlayers = [];
        foreach($result["players"] as $playerData) {
            $queuedPlayers[] = strtolower($playerData["name"]);
        }

        $plugin->getProvider()->fetchActions($queuedPlayers);
        $plugin->getLogger()->debug("FetchQueuedPlayersAsyncTask was successfully executed");
    }

}