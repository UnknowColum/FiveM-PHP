# FiveM-PHP 

___
- ServerFilter [EMPTY, GET_PLAYER, GET_RESOURCES, GET_VARS]
```php
echo (new Serverslist)->Get()->Server(['149.202.65.148', 30120], ServerFilter::EMPTY);
```
___
- ServerlistFilter [EMPTY, GET_PLAYER, GET_RESOURCES, GET_SERVERS]
```php

try {
    echo (new Serverslist)->Get()->Global(ServerlistFilter::GET_PLAYER);
} catch (Exception $e) {
}
```
___
- DirectServerFilter [PLAYERS, SERVER_INFO]
```php
try {
    echo (new DirectServer())->Get()->Server(["149.202.65.148", 30120], DirectServerFilter::SERVER_INFO);
} catch (EmptyDirectServerFilterException $e) {
}
```