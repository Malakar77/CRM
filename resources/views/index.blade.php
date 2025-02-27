
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/index.css', 'resources/css/helper.css',])
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="CRM AKСплав">
    <meta name="author" content="Data Jalagoniya d.jalagoniya@aksplav.ru">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>

</head>

<body><!-- Button trigger modal -->
<div id="particles-js"></div>

<div class="container justify-content-center">
    <div class="row justify-content-center align-items-center p-3 blockForm" style="backdrop-filter: blur(50px); ">
        <div class="col-12" >
            <div class="welcome_text" data-text="{{ env('APP_NAME', 'CRM') }}">{{ env('APP_NAME', 'CRM') }}</div>
        </div>
        <div class="col-12">
            <form id="login_form">
                <div class="input-box">
                    <input id="login" class="login" autofocus="autofocus" placeholder="Логин"  data-enter="sent"/>
                </div>
                <div class="input-box">
                    <input id="password" type="password" class="pass" value="" placeholder="Пароль"  data-enter="sent"/>
                    <span class=" unit material-symbols-outlined">visibility_off</span>
                </div>
                <div class="row">
                    <div class="col mb-5">
                        <button class="glow-on-hover" type="button" data-action="sent">Вход</button>
                        <div class="error"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row" style="position: sticky; bottom: 0; color: #f9fafa; max-width: 100%">
    <div class="col">
        <p class="footer_logo" style="float: right;">
            {{ env('APP_NAME', 'CRM') }} <i class="bi bi-airplane-engines"></i>
        </p>
    </div>
</div>

@vite([
       'resources/js/common.js',
       'resources/js/auth.js',
       'resources/js/index.js',
       'resources/js/particles.js',
       'resources/js/particles_in.js'
       ])

</body>
</html>
