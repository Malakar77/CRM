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
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 15%;">
        <div  class="container">
            <div class="row">
                <div class="col-3 ps-0">
                    <img src="{{ env('LOGO_CRM', '/icon/logo.svg') }}" alt="logo" style="width: 40px; margin-right: 15px;">
                </div>
                <div class="col-9 ps-0 block-name-company">
                    <span class="name-company">{{ env('APP_NAME_COMPANY', 'CRM') }}</span>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills flex-column  mt-4">
            <ul class="list-unstyled ps-0"></ul>
            <li class=" my-3"></li>
        </ul>
        <div class="mb-auto">
            <h6 style="border-bottom: 1px solid #f0f1f2; width: 50%;" >Избранное</h6>

            <ul class="list-unstyled fw-normal pb-1 small favorites">
            </ul>
        </div>
        <div class="mt-auto block_clock">
            <div id="date_block"></div>
            <div id="clock"></div>
        </div>
        <div class="mb-1">
            <div class="dropdown border-top">
                <a href="#" class="d-flex align-items-start justify-content-start p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->link_ava }}" alt="mdo" width="24" height="24" class="rounded-circle me-2">
                    <strong class="align-middle" id="nameUser" style="font-size: 13px; color: #f0f1f2; text-overflow: ellipsis;
  overflow: hidden;">{{ Auth::user()->name }}</strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                    <li><a class="dropdown-item" href="/profile">Профиль</a></li>
                    <li><a class="dropdown-item" href="/setting">Настройки</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item exitUser" href="#">Выход</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="body mt-3">
            <div class="row">
                <div class="col-4 ps-0 pe-0">
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

                <div class="col-8 ps-2">
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
<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class=" my-1 theme-icon-active bi bi-moon-stars" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z"/>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
        </svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                Light
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark" aria-pressed="true">
                <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                Dark
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
                <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
                Auto
                <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
            </button>
        </li>
    </ul>
</div>

<!--модельное окно ошибки-->
<div class="modal fade modal-lg" id="error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title errorTitle" id="exampleModalLabel">Ошибка</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ui-icon">
                    <div class="ui-lock" style="margin: 0 auto; width: 145px;">
                        <img src="../icon/error.svg" alt="error" style="width: 142px"></div>
                </div>
                <h2 class="title-modal_count" style="text-align: center;">Ошибка</h2>
                <p class="title-modal_count" style="text-align: center;">Возникла ошибка, попробуйте позже или обратитесь к администратору</p>
            </div>
            <div class="modal-footer " >
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


@vite([
    'resources/js/script.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/profile.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
