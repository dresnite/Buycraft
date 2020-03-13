<?php


namespace GiantQuartz\queue;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class QueueListener implements Listener {

    /** @var Queue */
    private $queue;

    public function __construct(Queue $queue) {
        $this->queue = $queue;
    }

    public function onPlayerJoin(PlayerJoinEvent $event) {
        $this->queue->executeQueuedActions($event->getPlayer());
    }

}