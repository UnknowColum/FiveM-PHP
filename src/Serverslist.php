<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class Serverslist
{

    const SERVERS_LIST = 'https://servers-live.fivem.net/api/servers/';

    /**
     * Serverslist constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return Serverslist
     */
    public static function Get()
    {
        return new self();
    }


    /**
     * @param array $array
     * @param int $filter
     * @return string
     */
    public static function Server(array $array, int $filter = null)
    {
        if (!empty($array[0]) && !empty($array[1])) {
            $request = self::HttpRequest();
            header('Content-Type: application/json');
            if (!empty($filter)) {
                switch ($filter) {
                    case ServerFilter::GET_PLAYER:
                        return \GuzzleHttp\json_encode(self::FilterServer($request, $array[0], $array[1])->Data->players);
                        break;
                    case ServerFilter::GET_RESOURCES:
                        return \GuzzleHttp\json_encode(self::FilterServer($request, $array[0], $array[1])->Data->resources);
                        break;
                    case ServerFilter::GET_VARS:
                        return \GuzzleHttp\json_encode(self::FilterServer($request, $array[0], $array[1])->Data->vars);
                        break;
                    case ServerFilter::EMPTY;
                        return \GuzzleHttp\json_encode(self::FilterServer($request, $array[0], $array[1])->Data);
                        break;
                }
            } else {
                return \GuzzleHttp\json_encode(self::FilterServer($request, $array[0], $array[1])->Data);
            }
        } else {
            header('Content-Type: application/json');
            return \GuzzleHttp\json_encode([
                'error' => true
            ]);
        }
    }


    /**
     * @param null $filter
     * @return int|string
     * @throws Exception
     */
    public static function Global($filter = null)
    {
        $request = self::HttpRequest();
        if (!empty($filter)) {
            header('Content-Type: application/json');
            switch ($filter) {
                case ServerlistFilter::GET_PLAYER:
                    return self::FilterCount($request, ['players']);
                    break;
                case ServerlistFilter::GET_RESOURCES:
                    return self::FilterCount($request, ['resources']);
                    break;
                case ServerlistFilter::GET_SERVERS:
                    return self::FilterCount($request);
                    break;
                case ServerlistFilter::EMPTY;
                    return $request;
                    break;
            }
        } else {
            header('Content-Type: application/json');
            return $request;
        }
    }


    /**
     * @param $request
     * @param $array
     * @return int|mixed
     * @throws Exception
     */
    private static function FilterCount($request, $array = null)
    {
        $collect = collect([]);
        $playersOnlineCount = 0;
        $request = \GuzzleHttp\json_decode($request);
        if (!empty($array)) {
            if (count($array) >= 1) {
                for ($i = 0; $i < count($request); ++$i) {
                    $collect->push(count($request[$i]->Data->{$array[0]}));
                }
            } else {
                throw new FilterCountException("FilterCount is not >= 1");
            }
            foreach ($collect as $item) {
                $playersOnlineCount += $item;
            }
            return $playersOnlineCount;
        } else {
            return count($request);
        }
    }

    /**
     * @param $request
     * @param $ip
     * @param $port
     * @return mixed
     */
    private static function FilterServer($request, $ip, $port)
    {
        $collect = collect([]);
        $array_value = \GuzzleHttp\json_decode($request);
        for ($i = 0; $i < count($array_value); ++$i) {
            if ($array_value[$i]->EndPoint == $ip . ':' . $port) {
                $collect->push($array_value[$i]);
            }
            foreach ($collect as $value) {
                return $value;
            }
        }
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    private static function HttpRequest()
    {
        $client = new Client([
            'timeout' => 6.0,
            'headers' => [
                'Accept' => "application/json",
            ],
        ]);
        try {
            $response = $client->request('GET', self::SERVERS_LIST);
            return $response->getBody();
        } catch (GuzzleException $e) {
        }
    }
}