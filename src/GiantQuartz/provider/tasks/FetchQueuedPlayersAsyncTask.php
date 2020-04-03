<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\ProviderAsyncTask;
use pocketmine\Server;

class FetchQueuedPlayersAsyncTask extends ProviderAsyncTask {

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $this->executeCurl($this->getCurlSession());
    }

    /**
     * @param Server $server
     * @throws Exception
     */
    public function onCompletion(Server $server): void {
        $plugin = $this->getBuycraft();
        $result = $this->getResult();

        if(isset($result["players"]) and is_array($result["players"])) { // Hacky: This check shouldn't be necessary
            foreach($result["players"] as $playerData) {
                $plugin->getProvider()->fetchQueuedPlayerActions($playerData["id"], $playerData["name"]);
                $plugin->getLogger()->debug("Requesting queued player {$playerData["name"]} actions");
            }
        }

        $plugin->getLogger()->debug("FetchQueuedPlayersAsyncTask was successfully executed");
    }

}