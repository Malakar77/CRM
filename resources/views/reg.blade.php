
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/reg.css','resources/sass/app.scss','resources/js/app.js',])

</head>

<body><!-- Button trigger modal -->
<div id="particles-js"></div>


<div class="container justify-content-center">
    <div class="row justify-content-center align-items-center">
        <div class="col-12">
            <div class="text-box">Регистрация</div>
            <form id="login_form">
                <div class="input-box">
                    <input value="" class="nameCompany" autofocus="autofocus" placeholder="ИНН Компании"/>
                </div>
                <div class="input-box">
                    <input value="" class="login" autofocus="autofocus" placeholder="Логин"/>
                </div>
                <div class="input-box">
                    <input type="password" class="pass" value="" placeholder="Пароль"/>
                </div>
                <div class="input-box">
                    <input type="password" class="passField" value="" placeholder="Пароль"/>
                </div>
                <div class="input-box">
                    <button class="glow-on-hover" data-action="registration" type="button">Зарегистрироваться</button>
                    <button type="button" class="btn btn-outline-primary butBack" data-action="back">Назад</button>
                    <div class="error" style=""><p class="pError"></p></div>
                </div>
            </form>
        </div>
    </div>
</div>

@vite([
    'resources/js/common.js',
    'resources/js/particles.js',
    'resources/js/particles_in.js',
    'resources/js/reg.js'
    ])

</body>
</html>
