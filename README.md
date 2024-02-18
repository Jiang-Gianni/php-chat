# php-chat

PHP Monolithic version of [Chat](https://github.com/Jiang-Gianni/chat?tab=readme-ov-file#demo)

## Demo

https://github.com/Jiang-Gianni/php-chat/assets/71674846/9e4540f6-c328-418b-9d54-371a7448866f


## Sqlite3

Edit the `php.ini` file stored in `/etc/php.ini` and add the line:

```ini
extension=sqlite3.so
```

## WebSocket

https://github.com/ratchetphp/Ratchet

```bash
composer require cboden/ratchet
```


## Start Server HTTP (port 8888) + Server WS (port 8080)

ok, not really a monolith.

I couldn't find a way to integrate Web Socket within PHP's built-in web server so two separate active processes are needed.

```bash
php -S localhost:8888
```

```bash
php ws.php
```
