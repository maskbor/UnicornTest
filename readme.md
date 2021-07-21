## Требования
- php: ^7.1.3
- composer
- postgres: 13^

## Установка

- git clone https://github.com/maskbor/UnicornTest.git
- cd ./UnicornTest
- composer install
- заполнить .env для доступа к бд, для проверки отправки писем указать MAIL_DRIVER=log, очереди QUEUE_CONNECTION=database
- php artisan migrate
- для заполнения бд выполнить 
    php artisan db:seed
- php artisan queue:work
- Для запуска рассылки пользователям выполнить
php artisan email:send [options]

options:
      --action[=ACTION]  ID акции
      --groupAll         Разослать письма всем группам пользователей
      --groupA           Разослать письма тем пользователям, у кого есть хотя бы одна авторизация
      --groupB           Разослать письма тем пользователям, у кого больше двух авторизаций за прошедший месяц
      --groupC           Разослать письма тем пользователям, у кого есть хотя бы одна авторизация за прошлый месяц и не было авторизации в период действия акции
    

