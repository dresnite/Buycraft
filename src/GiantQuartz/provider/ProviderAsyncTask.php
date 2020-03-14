<?php


namespace GiantQuartz\provider;


use Exception;
use GiantQuartz\Buycraft;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

abstract class ProviderAsyncTask extends AsyncTask {

    /** @var string */
    protected const QUEUE_URL = "https://plugin.tebex.io/queue/";

    /** @var string */
    protected $secretKey;

    public function __construct(Provider $provider) {
        $this->secretKey = $provider->getSecretKey();
    }

    /**
     * @return Plugin|Buycraft
     * @throws Exception
     */
    protected function getBuycraft(): Plugin {
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("Buycraft");
        if($plugin === null) {
            throw new Exception("Tried to execute an async task while the Buycraft plugin is disabled");
        }
        return $plugin;
    }

    protected function getCurlSession(string $url = self::QUEUE_URL) {
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_HTTPHEADER, [
            "X-Tebex-Secret: " . $this->secretKey
        ]);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_TIMEOUT, 5);
        return $session;
    }

    protected function setCurlOptions($curl, array $options): void {
        foreach($options as $option => $value) {
            curl_setopt($curl, $option, $value);
        }
    }

    /**
     * @param $curl
     * @throws Exception
     */
    protected function executeCurl($curl): void {
        $result = curl_exec($curl);
        $this->checkCurlResult($result, curl_error($curl));
        curl_close($curl);
        $this->setResult(json_decode($result, true));
    }

    /**
     * @param $result
     * @param $error
     * @throws Exception
     */
    private function checkCurlResult($result, $error): void {
        if($result === false) {
            throw new Exception("Query error: $error");
        }
    }

}