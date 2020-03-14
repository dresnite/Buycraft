<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\ProviderAsyncTask;
use pocketmine\command\ConsoleCommandSender;

class FetchOfflineCommandsAsyncTask extends ProviderAsyncTask {

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $this->executeCurl($this->getCurlSession(self::QUEUE_URL . "offline-commands"));
    }

    /**
     * @throws Exception
     */
    public function onCompletion(): void {
        $plugin = $this->getBuycraft();

        $commandIdsExecuted = [];
        foreach($this->getResult()["commands"] as $commandData) {
            $commandIdsExecuted[] = $commandData["id"];
            $plugin->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender(), str_replace("{name}", $commandData["player"]["name"], $commandData["command"]));
        }

        $plugin->getProvider()->removeCommands($commandIdsExecuted);
        $plugin->getLogger()->debug("FetchOfflineCommandsAsyncTask was successfully executed");
    }

}