<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Регистрация</title>
    </head>
    <body style="margin: 0;
                padding: 0;
                background-color: #f0f0f0;
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #666666;">
        <table class="container" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 500px;
                    max-width: 500px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden; ">
            <tr>
                <td class="header" style="background-color: #0f4c81; /* Classic Blue */
                    color: #ffffff;
                    text-align: center;
                    padding: 20px 0;">
                    <h1 style="margin: 0;
                    font-size: 24px;">Добро пожаловать</h1>
                </td>
            </tr>
            <tr>
                <td align="center" style=" display:block; margin: 15px;">Регистрация прошла успешно</td>
            </tr>
            <tr>
                <td align="center" style=" display:block; margin: 15px;">Ваш логин: {{$login}}</td>
            </tr>
            <tr>
                <td align="center" style=" display:block; margin: 15px;">Ваш пароль: {{$password}}</td>
            </tr>
            <tr>
                <td class="footer" style="text-align: center;
                    padding: 20px;
                    color: #999999;
                    border-top: 2px solid #eeeeee;
                    font-size: 14px;">
                    <p>&copy; 2025 АК Сплав. Все права защищены.</p>
                </td>
            </tr>
        </table>
    </body>
</html>
