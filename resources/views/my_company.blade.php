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
@include('theme')

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
