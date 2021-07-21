<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
    </head>
    <body>
        <div>
            <p>
                Здравствуйте, {{ $fio }}, Вы давно не появлялись на сервисе, узнайте последние новости по ссылке: 
                    <a href="https://google.ru">google.ru</a>
            </p>
        </div>
    </body>
</html>
