# FiveM-PHP 🐌
![packagist-stable](https://badgen.net/packagist/v/itexzoz/fivem-php)
![packagist-license](https://img.shields.io/packagist/l/itexzoz/fivem-php.svg)
![packagist-download](https://badgen.net/packagist/dt/itexzoz/fivem-php)

## Installation
Pull in the project using composer:
`composer require itexzoz/fivem-php`

### Constants
```
ServerFilter [ EMPTY, GET_PLAYER, GET_RESOURCES, GET_VARS]

ServerlistFilter [EMPTY, GET_PLAYER, GET_RESOURCES, GET_SERVERS]

DirectServerFilter [PLAYERS, SERVER_INFO]
```

## Get specific server information from FiveM Masterlist

```php
echo (new Serverslist)->Get()->Server(['149.202.65.148', 30120], ServerFilter::EMPTY);
```
```php
try {
    echo (new Serverslist)->Get()->Global(ServerlistFilter::EMPTY);
} catch (Exception $e) {
}
```

## Get specific server information with direct connect
```php
try {
    echo (new DirectServer())->Get()->Server(["149.202.65.148", 30120], DirectServerFilter::SERVER_INFO);
} catch (EmptyDirectServerFilterException $e) {
}
```
