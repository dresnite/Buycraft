<?php


namespace GiantQuartz\utils;


use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;

class BuycraftCommand {

    /** @var int */
    private $identifier;

    /** @var string */
    private $command;

    public function __construct(string $identifier, string $command) {
        $this->identifier = $identifier;
        $this->command = $command;
    }

    public function getIdentifier(): int {
        return $this->identifier;
    }

    public function getCommand(): string {
        return $this->command;
    }

    public function execute(): void {
        Server::getInstance()->getCommandMap()->dispatch(new ConsoleCommandSender(), $this->command);
    }

}