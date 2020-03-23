<?php


namespace GiantQuartz\provider\tasks;


use Exception;
use GiantQuartz\provider\Provider;
use GiantQuartz\provider\ProviderAsyncTask;
use pocketmine\Server;

class RemoveCommandsAsyncTask extends ProviderAsyncTask {

    /** @var string */
    private $identifiers;

    public function __construct(Provider $provider, array $identifiers) {
        $this->identifiers = implode("&ids[]=", $identifiers);
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
            CURLOPT_POSTFIELDS => "ids[]=$this->identifiers"
        ]);
        $this->executeCurl($curl);
    }

    /**
     * @param Server $server
     * @throws Exception
     */
    public function onCompletion(Server $server): void {
        $this->getBuycraft()->getLogger()->debug("RemoveCommandsAsyncTask was successfully executed");
    }

}