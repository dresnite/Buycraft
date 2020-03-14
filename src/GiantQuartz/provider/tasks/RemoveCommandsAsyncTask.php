<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;
use pocketmine\Server;

class RemoveCommandsAsyncTask extends ProviderAsyncTask {

    /** @var array */
    private $identifiers;

    public function __construct(Provider $provider, array $identifiers) {
        $this->identifiers = $identifiers;
        parent::__construct($provider);
    }

    /**
     * @throws Exception
     */
    public function onRun(): void {
        $curl = $this->getCurlSession();
        $this->setCurlOptions($curl, [
            CURLOPT_FAILONERROR => true,
            CURLOPT_POST => 1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => "ids[]=" . implode("&ids[]=", $this->identifiers)
        ]);
        $this->executeCurl($curl);
    }

    public function onCompletion(): void {
        Server::getInstance()->getLogger()->debug("RemoveCommandsAsyncTask was successfully executed");
    }

}