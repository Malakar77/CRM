<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/client.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRM AKСплав">
    <meta name="author" content="Data Jalagoniya d.jalagoniya@aksplav.ru">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
</head>
<body>
<main class="d-flex flex-nowrap">
    @include('sidebar')
    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="head">
            <div class="row">
                <div class="py-2 mb-2 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center " style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" id="search" class="form-control searchCompany" placeholder="Search..." aria-label="Search" data-change="search" data-enter="search">
                            </form>
                        </div>
                        <div class="col-7 col-md-2">
                            <button type="button" class="btn btn-outline-primary btn-desktop add-user" data-click="addCompanyClient">
                                <i class="bi bi-plus-circle" data-click="addCompanyClient"></i>
                                Добавить
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-mobile" data-click="addCompanyClient">
                                <i class="bi bi-plus-circle" data-click="addCompanyClient"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row justify-content-start">
                <div class="col-12 col-md-3 mb-3 ps-0 pe-2">
                    <div class="d-grid gap-3 company_list" style="min-height: 93vh; max-height: 92vh">
                        <div class="bg-body-tertiary border rounded-3 p-2 allSaleAdmin">

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9  mb-3 check_list" style="height: 90vh; overflow: scroll; overflow-x: hidden ">
                    <div class="mb-3" id="delailsBlock"></div>
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


<div class="modal fade" id="sentMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 headMessage" id="staticBackdropLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="formMassage">
                    <div class="mb-3">
                        <label for="sumProvider" class="form-label">Сумма закупки</label>
                        <input type="text" class="form-control" id="sumProvider" name="sumProvider">
                        <input type="hidden" class="form-control" id="idSale" name="idSale">
                    </div>
                    <div class="mb-3">
                        <label for="sumLogist" class="form-label">Сумма логистики</label>
                        <input type="text" class="form-control" id="sumLogist" name="sumLogist">
                    </div>
                    <div class="mb-3">
                        <label for="countDayLogist" class="form-label">Срок доставки</label>
                        <input type="text" class="form-control" id="countDayLogist" name="countDayLogist">
                    </div>
                    <div class="mb-3">
                        <label for="countDayPay" class="form-label">Срок оплаты</label>
                        <input type="email" class="form-control" id="countDayPay" name="countDayPay">
                    </div>
                    <div class="mb-3">
                        <label for="usloviya" class="form-label">Условия</label>
                        <input type="email" class="form-control" id="usloviya" name="usloviya">
                    </div>
                </form>
                <div class="mb-3">
                    <div id="file" class="form-text">
                        <i class="bi bi-file-earmark-pdf"></i>
                        Будет отправлен pdf фаил счета
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-click="sentMessage">Отправить</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-xl" id="exel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создание счета из файла</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <div class="row">
                            <!-- Поле для выбора файла -->
                            <div class="col-12 col-md-8">
                                <input class="form-control input-File" type="file" id="formFile" placeholder="Выберите файл" style="border: 1px solid green;">
                            </div>

                            <!-- Кнопка для загрузки -->
                            <div class="col-12 col-md-4 mt-2 mt-md-0">
                                <button type="button" class="btn btn-outline-primary w-100" data-click="sentFileExel">Загрузить</button>
                            </div>
                        </div>

                        <!-- Сообщение об ошибке -->
                        <p class="errorFileContract text-danger mt-2"></p>
                    </div>
                    <div class="col-12" style="max-height: 80vh; overflow: scroll; overflow-x: auto;">
                        <table class="table table-hover exelTable" >
                            <thead id="theadExel"></thead>
                            <tbody id="exelBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-click="addCheckFile">Создать</button>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Режим редактирования</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">

            <fieldset disabled>
                <div class="mb-3">
                    <label for="nameCompanyEdit" class="form-label">Компания</label>
                    <input type="text" id="nameCompanyEdit" class="form-control" >

                    <div id="emailHelp" class="form-text">Изминению не подлежит</div>
                </div>
            </fieldset>
            <fieldset disabled>
                <div class="mb-3">
                    <label for="innEditCompany" class="form-label">ИНН</label>
                    <input type="text" id="innEditCompany" class="form-control" >
                    <div id="emailHelp" class="form-text">Изминению не подлежит</div>
                </div>
            </fieldset>
            <fieldset disabled>
                <div class="mb-3">
                    <label for="urAdressEditCompany" class="form-label">Адрес Юридический</label>
                    <input type="text" id="urAddressEditCompany" class="form-control" >
                    <div id="emailHelp" class="form-text">Изминению не подлежит</div>
                </div>
            </fieldset>
            <div class="mb-3">
                <label for="contactEditCompany" class="form-label">Контакт</label>
                <input type="text" class="form-control" id="contactEditCompany" >
            </div>
            <div class="mb-3">
                <label for="phoneEditCompany" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="phoneEditCompany" >
            </div>
            <div class="mb-3">
                <label for="emailEditCompany" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="emailEditCompany" >
            </div>
            <div class="mb-3">
                <label class="form-label">Сайт</label>
                <input type="text" class="form-control" id="siteEditCompany">
            </div>
            <div class="mb-3">
                <label for="selectUserCompany" class="form-label">Сотрудник</label>
                <select class="form-select " id="selectUserCompany" aria-label="Default select example" >
                </select>
            </div>
            <button class="btn btn-primary" data-click="saveEditCompany">Сохранить</button>

    </div>
</div>

<div class="modal fade modal-xl" id="addCompanyClient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dropzoneModalDiag" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Добавить клиента</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="addFormCompany">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control searchInn" id="searchInn" placeholder="ИНН компании" aria-label="Введите ИНН компании" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary button-addon2" type="button" data-click="searchForInn">Поиск</button>
                    </div>
                    <div class="errorSearch form-text mb-3" style="color: red"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addNameCompany" class="form-label">Имя компании</label>
                                <input type="text" class="form-control" id="addNameCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="addInnCompany" class="form-label">ИНН</label>
                                <input type="text" class="form-control" id="addInnCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="addKppCompany" class="form-label">КПП</label>
                                <input type="text" class="form-control" id="addKppCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="addUrAdresCompany" class="form-label">Адрес юридический</label>
                                <input type="text" class="form-control" id="addUrAddressCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <div class="mb-3">
                                <label for="addUserCompany" class="form-label">Контакт</label>
                                <input type="text" class="form-control" id="addUserCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="addUserPhoneCompany" class="form-label">Телефон</label>
                                <input type="text" class="form-control" id="addUserPhoneCompany" >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="addUserEmailCompany" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="addUserEmailCompany"  >
                                <div class="form-text">*Обязательно для заполнения</div>
                            </div>
                            <div class="mb-3">
                                <label for="selectUserCompany" class="form-label">Сотрудник</label>
                                <select class="form-select " id="addManager" aria-label="Default select example" >
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 textArea">
                        <label for="textAreaInput" class="form-label">Комментарий</label>
                        <textarea class="form-control" id="textAreaInput" rows="3" data-input="comment"></textarea>
                        <div class="text" id="countText">Введено 0 из 255 символов</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-primary submitFormAdd" data-click="setClient">Сохранить</button>
            </div>
        </div>
    </div>
</div>

@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/client.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
