<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;
use GiantQuartz\utils\BuycraftCommand;
use pocketmine\Server;

class FetchQueuedPlayerActionsAsyncTask extends ProviderAsyncTask {

    /** @var array */
    private $playerId;

    /** @var string */
    private $playerName;

    public function __construct(Provider $provider, int $playerId, string $playerName) {
        $this->playerId = $playerId;
        $this->playerName = $playerName;
        parent::__construct($provider);
    }

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $this->executeCurl($this->getCurlSession(self::QUEUE_URL . "online-commands/$this->playerId"));
    }

    /**
     * @param Server $server
     * @throws Exception
     */
    public function onCompletion(Server $server): void {
        $plugin = $this->getBuycraft();
        $result = $this->getResult();

        $commands = [];
        foreach($result["commands"] as $commandData) {
            $commands[] = new BuycraftCommand($commandData["id"], str_replace("{name}", $this->playerName, $commandData["command"]));
        }

        $queue = $plugin->getQueue();
        $queue->addAction($this->playerName, $commands);
        $queue->checkOnlinePlayers();

        $plugin->getLogger()->debug("FetchQueuedPlayerActionsAsyncTask was successfully executed for {$this->playerName}");
    }

}