<?php


namespace GiantQuartz\queue;


use GiantQuartz\Buycraft;
use pocketmine\command\ConsoleCommandSender;

class QueueAction {

    /** @var Buycraft */
    private $plugin;

    /** @var string */
    private $targetName;

    /** @var string[] */
    private $commands;

    public function __construct(Buycraft $plugin, string $targetName, array $commands) {
        $this->plugin = $plugin;
        $this->targetName = $targetName;
        $this->commands = $commands;
    }

    public function getTargetName(): string {
        return $this->targetName;
    }

    public function getCommands(): array {
        return $this->commands;
    }

    public function execute(): void {
        $commandMap = $this->plugin->getServer()->getCommandMap();
        foreach($this->commands as $command) {
            $commandMap->dispatch(new ConsoleCommandSender(), $command);
        }

        $this->plugin->getProvider()->removeCommands($this->commands);
        $this->plugin->getQueue()->removeAction($this->targetName);
    }

}