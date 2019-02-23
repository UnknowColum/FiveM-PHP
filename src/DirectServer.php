<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DirectServer
{

    const PLAYERS = "/players.json";

    const INFO = "/info.json";

    /**
     * DirectServer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return DirectServer
     */
    public function Get()
    {
        return new self();
    }

    /**
     * @param array $array
     * @param int|null $filter
     * @return string
     * @throws EmptyDirectServerFilterException
     */
    public static function Server(array $array, int $filter = null)
    {
        if (!empty($array[0]) && !empty($array[1])) {
            header('Content-Type: application/json');
            if (!empty($filter)) {
                switch ($filter) {
                    case DirectServerFilter::PLAYERS;
                        $request = self::HttpRequest($array[0], $array[1], self::PLAYERS);
                        return $request;
                        break;
                    case DirectServerFilter::SERVER_INFO;
                        $request = self::HttpRequest($array[0], $array[1], self::INFO);
                        return $request;
                        break;
                }
            } else {
                throw new EmptyDirectServerFilterException("Missing filter");
            }
        } else {
            header('Content-Type: application/json');
            return \GuzzleHttp\json_encode([
                'error' => true
            ]);
        }
    }


    /**
     * @param $ip
     * @param $port
     * @param $type
     * @return \Psr\Http\Message\StreamInterface
     */
    private static function HttpRequest($ip, $port, $type)
    {
        $client = new Client([
            'timeout' => 6.0,
            'headers' => [
                'Accept' => "application/json",
            ],
        ]);
        try {
            $response = $client->request('GET', $ip . ":" . $port . $type);
            return $response->getBody();
        } catch (GuzzleException $e) {
        }
    }

}