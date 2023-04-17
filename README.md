# MQTT Transport demo repository

This is an example of how to use [kl3sk/mqtt-transport-bundle](https://packagist.org/packages/kl3sk/mqtt-transport-bundle)

Prerequisite: _Docker_

How to use:

```bash
git clone kl3sk/mqtt-transport-demo <folder>
cd <folder>
composer install
```

Create a `.env.local` file at the root of your project
```dotenv
DATABASE_URL="mysql://root:root@mariadb:3306/mqtt?serverVersion=mariadb-10.5.17&charset=utf8mb4"

MESSENGER_MQTT_TRANSPORT_DSN=mqtt://user:password@rabbitmq:1883
MQTT_CLIENT_ID=symfonyclient
MQTT_TOPICS='/topic1,/topic2'
```

Start docker stack:
```bash
docker-compose up -d
```

Start worker to consume message on configured topics (/topic1 and /topic2, in our case)
```bash
php bin/console  messenger:consume mqtt -vv
```

Send a MQTT message, you cas use [MQTT Explorer](https://mqtt-explorer.com/)

The message sent should be a JSON like this:
```json
{
    "content": "Any message you want"
}
```



_Note:_ Please note, I'm learning Symfony messenger and MQTT, any advice is appreciated.
