<?php


namespace GiantQuartz;


use GiantQuartz\provider\BuycraftProvider;
use GiantQuartz\provider\Provider;
use GiantQuartz\queue\Queue;
use pocketmine\plugin\PluginBase;

class Buycraft extends PluginBase {

    /** @var Provider */
    private $provider;

    /** @var Queue */
    private $queue;

    public function onLoad(): void {
        if(!is_dir($this->getDataFolder())) {
            mkdir($this->getDataFolder());
        }
        $this->saveDefaultConfig();
    }

    public function onEnable(): void {
        $this->provider = new BuycraftProvider($this);
        $this->provider->fetchOfflineCommands();
        $this->queue = new Queue($this);
    }

    public function getProvider(): Provider {
        return $this->provider;
    }

    public function getQueue(): Queue {
        return $this->queue;
    }

}