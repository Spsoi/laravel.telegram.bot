
```
docker-compose -f docker-compose.dev.yml up -d
```

```
docker-compose -f docker-compose.prod.yml up -d
```

DDD + Modules
```
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   ├── Models/
│   │   └── TelegramMessageModel.php
│   └── Modules/
│       └── TelegramBot/
│           ├── Application/
│           ├── Domain/
│           ├── Infrastructure/
│           └── Providers/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
│   ├── api.php
│   ├── channels.php
│   └── web.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── vendor/
└── artisan
```