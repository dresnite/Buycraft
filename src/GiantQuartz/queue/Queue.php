<?php


namespace GiantQuartz\queue;


use GiantQuartz\Buycraft;
use GiantQuartz\task\RefreshQueueTask;
use GiantQuartz\utils\BuycraftCommand;
use pocketmine\player\Player;

class Queue {

    /** @var Buycraft */
    private $plugin;

    /** @var QueueAction[] */
    private $actions = [];

    public function __construct(Buycraft $plugin) {
        $this->plugin = $plugin;
        $this->initialize();
    }

    public function executeQueuedActions(Player $player): void {
        $username = strtolower($player->getName());
        if(array_key_exists($username, $this->actions)) {
            $this->actions[$username]->execute();
        }
    }

    /**
     * @param string $targetName
     * @param BuycraftCommand[] $commands
     */
    public function addAction(string $targetName, array $commands): void {
        $this->actions[$targetName] = new QueueAction($this->plugin, $targetName, $commands);
    }

    public function removeAction(string $targetName): void {
        unset($this->actions[strtolower($targetName)]);
    }

    public function refresh(): void {
        $this->plugin->getProvider()->fetchQueuedPlayers();
    }

    private function initialize(): void {
        $this->plugin->getScheduler()->scheduleRepeatingTask(new RefreshQueueTask($this), 20 * 60 * 5);
        $this->plugin->getServer()->getPluginManager()->registerEvents(new QueueListener($this), $this->plugin);
        $this->refresh();
    }

}