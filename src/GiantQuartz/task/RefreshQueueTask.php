<?php


namespace GiantQuartz\task;


use GiantQuartz\queue\Queue;
use pocketmine\scheduler\Task;

class RefreshQueueTask extends Task {

    /** @var Queue */
    private $queue;

    public function __construct(Queue $queue) {
        $this->queue = $queue;
    }

    public function onRun(int $currentTick): void {
        $this->queue->refresh();
    }

}