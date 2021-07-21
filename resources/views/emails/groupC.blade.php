<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
    </head>
    <body>
        <div>
            <p>
                Здравствуйте, {{ $fio }}, Вы выбраны для участия в акции {{ $action->title }}. Успейте до {{ $action->date_end }} принять участие.
            </p>
        </div>
    </body>
</html>
