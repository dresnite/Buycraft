<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;
use GiantQuartz\utils\BuycraftCommand;

class FetchQueuedPlayerActions extends ProviderAsyncTask {

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
     * @throws Exception
     */
    public function onCompletion(): void {
        $plugin = $this->getBuycraft();
        $result = $this->getResult();

        $commands = [];
        foreach($result["commands"] as $commandData) {
            $commands[] = new BuycraftCommand($commandData["id"], str_replace("{name}", $this->playerName, $commandData["command"]));
        }

        $plugin->getQueue()->addAction($this->playerName, $commands);
    }

}