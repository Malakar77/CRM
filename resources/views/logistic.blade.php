<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <style>
        .emptyInput{
            border: 1px red solid;
        }

        .active{
            background-color: #94999d !important;
            border: 1px #94999d solid !important;
        }

        .pen:hover{
            color: #0d6efd;
        }
        .bi-pencil:hover{
            color: #1B961D;
        }

        .dropdown-toggle::after{
            content: '';
            border-top: 0 solid;
        }

        td{
            vertical-align: middle;
        }

    </style>

    <!-- Custom styles for this template -->

</head>
<body>

<main class="d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 15%;">
        <div  class="container">
            <div class="row">
                <div class="col-3 ps-0">
                    <img src="{{ env('LOGO_CRM', 'icon/logo.svg') }}" alt="logo" style="width: 40px; margin-right: 15px;">
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
                    <strong class="align-middle" style="font-size: 13px; color: #f0f1f2; text-overflow: ellipsis;
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
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" class="form-control search" data-action="search" data-enter="enter" placeholder="Search..." aria-label="Search" name="search" value="">
                            </form>
                        </div>
                        <div class="d-flex">
                            <div style="width: 100%; display: block">
                                <div style="float: right;">
                                    <a class="btn btn-primary"  data-action="printArchive" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                        <i class="bi bi-archive" data-action="printArchive"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row justify-content-start">
                <div class="col-2">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary add-user" data-bs-toggle="modal" data-bs-target="#formModalAdd">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            Добавить
                        </button>
                    </div>
                    <div class="list-group mt-1" style="overflow: scroll; height: 80vh;">

                    </div>
                </div>
                <div class="col-10">
                    <div class="">
                        <table class="table table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th class="col-3">Имя</th>
                                <th class="col-3">Контакт</th>
                                <th class="col-4">Транспорт</th>
                                <th class="col-1">Город</th>
                                <th class="col-3">Информация</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="paginator" style="position: relative">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-items-center justify-content-center paginatorNav" style="align-items: center; justify-content: center; margin: 0 auto; display: flex;">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="name">Доп Информация</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container text-left">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Контакты</h5>
                                <p id="number">Грачев Игорь</p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5>Транспорт и услуги</h5>
                                <p id="transportDetails">Газель 1,5 тонны борт 6,0х2,08 грузы до 9 метров <br>Хёндай 5 тонник борт 4,85х2,2 грузы до 6 метров <br>Газель 1,5 тонны борт 4,2х2,0 грузы до 6 метров 3 машины, есть проходная в центр Москвы.<br>Газель 1,5 тонны борт 3,1х1,97 грузы до 6 метров 1 машина.<br>ВИС 850 кг борт 1,6х1,8 проходная в центр Москвы, 2 машины.<br>Тойота легковой универсал проходная в центр Москвы.<br><br>АДРЕС СКЛАДА И ОФИСА: МОСКВА УЛ. 6-Я РАДИАЛЬНАЯ 20 Стр.5 </p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5>Доп Информация</h5>
                                <p id="dopInfoDetails">1) Оплата по счету <br>2) ИП +20%<br>3)Обязательно нужно заполнить задание. <br>https://mp100.ru</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
    </div>
</div>
<div class="modal fade" id="formModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить Экспедитора</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd" data-action="validate">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Имя</label>
                        <input type="text" class="form-control name"  placeholder="Имя" name="name">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Фамилия</label>
                        <input type="text" class="form-control surname"  placeholder="Фамилия" name="surname">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Отчество</label>
                        <input type="text" class="form-control patronymic"  placeholder="Отчество" name="patronymic">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Телефон</label>
                        <input type="text" id="phone" class="form-control phone"  placeholder="+7 999 999 99 99" name="phone">
                        <div id="emailHelp" class="form-text">Не более 20 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Транспорт</label>
                        <input type="text" class="form-control transport"  placeholder="Газель 3тонны" name="transport">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Город</label>
                        <input type="email" class="form-control city" placeholder="Москва" name="city">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Доп. информация</label>
                        <textarea class="form-control info" rows="3" lang="ru" spellcheck="true" name="info"></textarea>
                        <div id="errorAdd" class="form-text">Дополнительная информация о логисте</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary submitInfo glow-on-hover AddLogisticSubmit" style="position: relative" data-action="addCompanyButton" disabled>Сохранить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-lg" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Доверенность</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="dov">
                    <div class="mb-3">
                        <div class="row">
                            <label for="exampleFormControlInput1" class="form-label labelSelect">
                                Компания

                            </label>
                            <div class="col-11">
                                <select id="select" class="js-selectize company" name="company" >
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary me-md-2 " data-action="addMyCompany" type="button">
                                    <i class="bi bi-plus-circle" data-action="addMyCompany" ></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label for="exampleFormControlInput1" class="form-label">№ доверенности</label>
                            <div class="col-11">
                                <input type="text" class="form-control number" placeholder="№ 123" name="numberDov">
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary me-md-2 plus" type="button">
                                    <i class="bi bi-plus-circle" data-action="plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Дата от</label>
                        <input type="date" class="form-control dateOt" name="date_ot">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Действует до</label>
                        <input type="date" class="form-control dateDo" name="date_do">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Документ</label>
                        <input type="text" class="form-control document_type mb-1"  placeholder="Паспорт" name="document">
                        <input type="text" class="form-control fio mb-1"  placeholder="Полное Имя" name="nameLogist">
                        <input type="text" class="form-control seria mb-1"  placeholder="Серия" name="seria">
                        <input type="text" class="form-control numberPassport mb-1"  placeholder="Номер паспорта" name="numberPassport">
                        <input type="text" class="form-control given mb-1"  placeholder="Кем выдан" name="given">
                        <input type="date" class="form-control dateGiven mb-1"  placeholder="Дата выдачи" name="dateGiven">
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label for="exampleFormControlInput1" id="selectProvider" class="form-label">
                                На получение от

                            </label>

                                <select id="companyProvider" class="companyProvider" name="companyProvider">
                                </select>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Доп. информация</label>
                        <textarea class="form-control dovInfo" id="exampleFormControlTextarea1" rows="3" name="info"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary  glow-on-hover" style="position: relative" data-action="submitDov">Сохранить</button>
            </div>
        </div>
    </div>
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

<div class="modal fade" id="addProvider" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1111">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить компанию</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="searchInn">
                    <div class="input-group mb-3">
                        <input type="text" id="inputAddCompanyInn" class="form-control inputAddCompanyInn" placeholder="Введите ИНН компании" aria-label="Имя пользователя получателя" aria-describedby="button-addon2" style="width: 70%">
                        <button class="btn btn-outline-primary " type="button" id="button-addon2" data-action="addCompanyInn">Поиск</button>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Название компания</label>
                        <input type="text" class="form-control" id="nameCompanySearch" name="nameCompanySearch">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">ИНН Компании</label>
                        <input type="text" class="form-control" id="innCompanySearch" name="innCompanySearch">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">КПП Компании</label>
                        <input type="text" class="form-control" id="kppCompanySearch" name="kppCompanySearch">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Юридический адрес</label>
                        <input type="text" class="form-control" id="adCompanySearch" name="adCompanySearch">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Фактический адрес</label>
                        <input type="text" class="form-control" id="urCompanySearch" name="urCompanySearch">
                    </div>
                    <div class="mb-3">
                        <label for="rasChet" class="form-label">Расчетный счет</label>
                        <input type="text" class="form-control" id="rasChet" name="rasChet">
                    </div>
                    <div class="input-group mb-3">
                        <label for="rasChet" class="form-label">Бик Банка</label>
                        <div class="input-group">
                            <input type="text" id="bikBankCompany" class="form-control" placeholder="Бик Банка"  style="width: 70%" name="bikBankCompany">
                            <button class=" btn btn-outline-primary" type="button" id="button-addon2" data-action="searchBank">Поиск</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bank" class="form-label">Бaнк</label>
                        <input type="text" class="form-control" id="bank" name="bank">
                    </div>
                    <div class="mb-3">
                        <label for="korChet" class="form-label">Кор.счет</label>
                        <input type="text" class="form-control" id="korChet" name="korChet">
                    </div>
                    <div class="mb-3">
                        <p class="errorBlock"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-primary addCompanyButton" data-action="addCompanyButton">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editmodalCompany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1111">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Редактировать компанию</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="editCompanyForm">
                    <div class="mb-3">
                        <label for="nameCompanyEdit" class="form-label">Название компания</label>
                        <input type="text" class="form-control" id="nameCompanyEdit" name="nameCompanyEdit">
                    </div>
                    <div class="mb-3">
                        <label for="innCompanyEdit" class="form-label">ИНН Компании</label>
                        <input type="text" class="form-control" id="innCompanyEdit" name="innCompanyEdit">
                    </div>
                    <div class="mb-3">
                        <label for="kppCompanyEdit" class="form-label">КПП Компании</label>
                        <input type="text" class="form-control" id="kppCompanyEdit" name="kppCompanyEdit">
                    </div>
                    <div class="mb-3">
                        <label for="adCompanyEdit" class="form-label">Юридический адрес</label>
                        <input type="text" class="form-control" id="adCompanyEdit" name="adCompanyEdit">
                    </div>
                    <div class="mb-3">
                        <label for="urCompanyEdit" class="form-label">Фактический адрес</label>
                        <input type="text" class="form-control" id="urCompanyEdit" name="urCompanyEdit">
                    </div>
                    <div class="mb-3">
                        <label for="rasChetEdit" class="form-label">Расчетный счет</label>
                        <input type="text" class="form-control" id="rasChetEdit" name="rasChetEdit">
                    </div>
                    <div class="mb-3">
                        <label for="bikBankEdit" class="form-label">БИК банка</label>
                        <input type="text" class="form-control" id="bikBankEdit" name="bikBankEdit">
                    </div>
                    <div class="mb-3">
                        <label for="bankEdit" class="form-label">Бaнк</label>
                        <input type="text" class="form-control" id="bankEdit" name="bankEdit">
                    </div>
                    <div class="mb-3">
                        <label for="korChetEdit" class="form-label">Кор.счет</label>
                        <input type="text" class="form-control" id="korChetEdit" name="korChetEdit">
                    </div>
                    <div class="mb-3">
                        <p class="errorBlock"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-primary" data-action="editCompanyButton">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Доверенности</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Компания</th>
                    <th scope="col">Дата</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody id="archive">
                </tbody>
            </table></div>
    </div>
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

<!--Конец модельное окно ошибки-->

@vite([
    'resources/js/script.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/logistic.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
