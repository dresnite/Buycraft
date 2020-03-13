<?php


namespace GiantQuartz\provider;


use pocketmine\scheduler\AsyncTask;

abstract class ProviderAsyncTask extends AsyncTask {

    /** @var string */
    protected $secretKey;

    /** @var string */
    private const QUEUE_URL = "https://plugin.tebex.io/queue";

    public function __construct(Provider $provider) {
        $this->secretKey = $provider->getSecretKey();
    }

    protected function getCurlSession() {
        $session = curl_init(self::QUEUE_URL);
        curl_setopt($session, CURLOPT_HTTPHEADER, [
            "X-Tebex-Secret: " . $this->secretKey
        ]);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_TIMEOUT, 5);
        return $session;
    }

}