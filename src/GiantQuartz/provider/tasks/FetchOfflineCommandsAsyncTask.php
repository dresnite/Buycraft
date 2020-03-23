<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\ProviderAsyncTask;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;

class FetchOfflineCommandsAsyncTask extends ProviderAsyncTask {

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $this->executeCurl($this->getCurlSession(self::QUEUE_URL . "offline-commands"));
    }

    /**
     * @param Server $server
     * @throws Exception
     */
    public function onCompletion(Server $server): void {
        $plugin = $this->getBuycraft();

        $commandIdsExecuted = [];
        foreach($this->getResult()["commands"] as $commandData) {
            $commandIdsExecuted[] = $commandData["id"];
            $plugin->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender(), str_replace("{name}", $commandData["player"]["name"], $commandData["command"]));
        }
        
        if(count($commandIdsExecuted) > 0) {
            $plugin->getProvider()->removeCommands($commandIdsExecuted);
        }

        $plugin->getLogger()->debug("FetchOfflineCommandsAsyncTask was successfully executed");
    }

}