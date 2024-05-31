# DockerLaravel
Репозиторий с настроенным для запуска в докере проектом

# Настроены
1. nginx
2. pgsql
3. php + laravel
4. rabbit mq
5. redis
6. cron

# Предустановлены:
1. Пакет для ролей nikitinuser/user-management-module
2. Пакет для jwt авторизации tymon/jwt-auth (все настроено)
3. Пакет для свагер аннотаций zircote/swagger-php
4. Пакет vladimir-yuldashev/laravel-queue-rabbitmq
5. Пакет predis/predis

# Для запуска бэка:
1. cd backend
2. cp .env.example .env
3. make install
4. make user-management-role-init
5. make jwt-init
6. sudo make up
7. make migrate
8. php artisan app:set-admin {id_user} // опционально

# Swagger
    Для генерации Swagger по аннотациям используются библиотеки:
        - zircote/swagger-php
        - doctrine/annotations
    Для запуска генерации выполнить команду:
        - ./vendor/bin/openapi app -o openapi.yaml
