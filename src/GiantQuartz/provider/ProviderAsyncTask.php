<?php


namespace GiantQuartz\provider;


use Exception;
use pocketmine\scheduler\AsyncTask;

abstract class ProviderAsyncTask extends AsyncTask {

    /** @var string */
    protected $secretKey;

    /** @var string */
    protected const QUEUE_URL = "https://plugin.tebex.io/queue/";

    public function __construct(Provider $provider) {
        $this->secretKey = $provider->getSecretKey();
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
        $this->checkCurlResult(curl_exec($curl), curl_error($curl));
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