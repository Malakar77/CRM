<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/profile.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">

    <style>



    </style>

    <!-- Custom styles for this template -->

</head>
<body>
<main class="d-flex flex-nowrap">
    @include('sidebar')

    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="body mt-3">
            <div class="row">
                <div class="col-12 col-md-4 ps-0 pe-0">
                    <div class="bg-body-tertiary border rounded-3">
                        <div class="row">
                            <div class="col">
                                <img src="{{Auth::user()->link_ava}}" alt="profile photo" id="photo" class="photo_user">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 ms-3">
                                <p>Ф.И.О.</p>
                            </div>
                            <div class="col-8 ms-3">
                                <p class="post">{{Auth::user()->name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 ms-3">
                                <p>Отдел</p>
                            </div>
                            <div class="col-8 ms-3">
                                <p class="post">{{Auth::user()->otdel}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 ms-3">
                                <p>Должность</p>
                            </div>
                            <div class="col-8 ms-3">
                                <p class="post">{{Auth::user()->dolzhost}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div class="bg-body-tertiary border rounded-3">
                            <div class="row ">
                                <div class="col ms-3 mt-1 ">
                                    <h5 class="header">Заработная плата</h5>
                                </div>
                            </div>
                            <div class="row zp_block">
                                <div class="col-5 ms-3">
                                    <p class="mb-1">Оклад</p>
                                </div>
                                <div class="col-6 ms-3">
                                    <p class="post">{{Auth::user()->oklad}} руб</p>
                                </div>
                            </div>
                            <div class="row zp_block">
                                <div class="col-5 ms-3 mb-1">
                                    <p class="mb-1">Премия до плана %</p>
                                </div>
                                <div class="col-6 ms-3">
                                    <p class="post">{{Auth::user()->zp_do_plan}}</p>
                                </div>
                            </div>
                            <div class="row zp_block mb-2">
                                <div class="col-5 ms-3">
                                    <p class="mb-1">Премия после плана %</p>
                                </div>
                                <div class="col-6 ms-3">
                                    <p class="post">{{Auth::user()->zp_posl_plan}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 ps-2">
                    <div class="row">
                        <div class="col">
                            <div class="bg-body-tertiary border rounded-3">
                                <div class="row ">
                                    <div class="col ms-3 mt-1 ">
                                        <h5 class="header">Имя пользователя</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 ">
                                            <label for="name" class="form-label mb-0">Имя</label>
                                            <input type="text" class="form-control" id="name" data-id="{{Auth::user()->id}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 ">
                                            <label for="surname" class="form-label mb-0">Фамилия</label>
                                            <input type="text" class="form-control" id="surname" data-id="{{Auth::user()->id}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="patronymic" class="form-label mb-0">Отчество</label>
                                            <input type="text" class="form-control" id="patronymic" data-id="{{Auth::user()->id}}">
                                        </div>
                                        <button type="button" class="btn btn-outline-primary button-signature" data-click="setName">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col">
                            <div class="bg-body-tertiary border rounded-3">
                                <div class="row ">
                                    <div class="col ms-3 mt-1 ">
                                        <h5 class="header">Управление почтой</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 ">
                                            <label for="pass" class="form-label mb-0">Пароль от почты</label>
                                            <input type="password" class="form-control" id="pass" data-id="{{Auth::user()->id}}" value="{{Auth::user()->pass_email}}">
                                        </div>
                                    </div>
                                    <div class="col-12 text_cont_block">
                                        <label for="text_signature" class="form-label ms-2 mb-0 mt-2">Подпись Email</label>
                                        <textarea id="text_signature" spellcheck="true" lang="ru" data-input="textarea">{{Auth::user()->signature}}</textarea>
                                        <div class="count_text" id="count_text">Введено 0 из 255 символов</div>
                                        <button type="button" class="btn btn-outline-primary button-signature" data-click="signature">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="bg-body-tertiary border rounded-3">
                                <div class="row">
                                    <div class="col ms-3 mt-1">
                                        <h5 class="header">Аватар</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 ">
                                            <label for="ava" class="form-label mb-0">Выберите фаил</label>
                                            <input type="file" class="form-control" id="ava" >
                                            <div class="errorFile mb-3">Фаил формата jpg/png</div>
                                            <button type="button" class="btn btn-outline-primary " data-click="setFile">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="position-fixed bottom-0 end-0 p-3 single" style="z-index: 100000; margin-bottom: 3%;">

</div>
@include('theme')

<!--модельное окно ошибки-->
@include('error')


@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/profile.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
