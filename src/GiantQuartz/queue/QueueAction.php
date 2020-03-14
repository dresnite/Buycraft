<?php


namespace GiantQuartz\queue;


use GiantQuartz\Buycraft;
use GiantQuartz\utils\BuycraftCommand;

class QueueAction {

    /** @var Buycraft */
    private $plugin;

    /** @var string */
    private $targetName;

    /** @var BuycraftCommand[] */
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
        $commandIds = [];
        foreach($this->commands as $command) {
            $commandIds[] = $command->getIdentifier();
            $command->execute();
        }

        $this->plugin->getProvider()->removeCommands($commandIds);
        $this->plugin->getQueue()->removeAction($this->targetName);
    }

}