<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/company.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
</head>
<body>

<main class="d-flex flex-nowrap">
    @include('sidebar')
    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center " style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" class="form-control searchCompany" placeholder="Search..." aria-label="Search" name="search" data-action="search" data-enter="enter">
                            </form>
                        </div>
                        <div class="col-2">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary add-company" data-action="addCompany">
                                    <i class="bi bi-database-fill-add" data-action="addCompany"></i>
                                    Добавить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body" >
            <div class="row justify-content-start">
                <div class="col-12 col-md-4  mb-3 discharge_list" style="height: 100%; padding: 0;">
                    <div class="d-grid gap-3 " style="height: 92vh;">
                        <div class="bg-body-tertiary border rounded-3 p-2">
                            <div class="mb-3 col-12" >
                                <table class="table table-hover tableExport" >
                                    <thead>
                                    <tr>
                                        <th>Выгрузка</th>
                                        <th>Дата</th>
                                        <th>Менеджер</th>
                                        <th>Кол-во</th>
                                    </tr>
                                    </thead>
                                    <tbody class="exportList"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4  mb-3 blockDatails" style="">
                    <div class="mb-3" style="height: 100%;">
                        <div class="row bg-body-tertiary border rounded-3 p-2" style="height: 92vh;">
                            <div class="container ">
                                <span class="btn-group">
                                    <button class="btn btn-default selected" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Выбрать все" data-action="selected">
                                        <i class="bi bi-check-all" data-action="selected"></i>
                                    </button>
                                    <button class="btn btn-default addManager" data-bs-toggle="tooltip" data-bs-placement="top" data-action="addManager" data-bs-title="Назначить ответственного" disabled style="border: none;  ">
                                        <i class="bi bi-person-check" data-action="addManager"></i>
                                    </button>
                                    <button class="btn btn-default delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Удалить" disabled style="border: none;" data-action="delete">
                                        <i class="bi bi-trash" data-action="delete"></i>
                                    </button>
                                </span>
                                <div class="table-container" style="height: 87vh; overflow: scroll;">
                                    <table class="table table-hover tableCompany"  style="">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-diamond-fill" viewBox="0 0 16 16">
                                                    <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L4.047 3.339 8 7.293l3.954-3.954L9.049.435zm3.61 3.611L8.708 8l3.954 3.954 2.904-2.905c.58-.58.58-1.519 0-2.098l-2.904-2.905zm-.706 8.614L8 8.708l-3.954 3.954 2.905 2.904c.58.58 1.519.58 2.098 0l2.905-2.904zm-8.614-.706L7.292 8 3.339 4.046.435 6.951c-.58.58-.58 1.519 0 2.098z"></path>
                                                </svg>
                                            </th>
                                            <th>ИНН</th>
                                            <th>Наименование</th>
                                            <th>Адрес</th>
                                            <th>Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody class="exportListCompany"></tbody>
                                    </table>

                                </div>
                                <div class="container text-center mt-3">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-auto">
                                            <nav>
                                                <div class="paginator" style="position: relative">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-items-center justify-content-center paginatorNav" style="align-items: center; justify-content: center; margin: 0 auto; display: flex;"></div>
                                                </div>
                                            </nav>
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

@include('theme')

<!-- Modal -->
<div class="modal fade modalManager" id="selectManagerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Назначить ответственного</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Название выгрузки</label>
                    <input type="text" class="form-control nameText" id="exampleFormControlInput1" placeholder="Введите Название выгрузки">
                </div>
                <div class="mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Менеджер</label>
                    <select class="form-select selectManager" aria-label="Default select example" name="selectManager">
                    </select>
                </div>
                <div class="mt-3 count form-text">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-action="setManager">Назначить</button>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно -->
<div class="modal fade " id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Загрузка компаний</h1>
                <button type="button" class="btn-close butClose" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="formSearch">
                    <div class="row">
                        <div class="alert alert-primary" role="alert">
                            Название компании | ИНН | Адрес компании
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Выберите фаил в формате xlsx</label>
                            <input class="form-control inputFile" type="file" id="formFile" name="file">
                            <div id="errorBlock" class="form-text">
                                Фаил должен соответствовать формату .xlsx
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary butClose" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary saveCompany" data-action="saveCompany">Загрузить</button>
            </div>
        </div>
    </div>
</div>







@include('error')

<!--Конец модельное окно ошибки-->



<!--модельное окно отсутствия прав-->

<div class="modal fade modal-lg" id="errorAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <p class="title-modal_count" style="text-align: center;">Нет прав для выполнения этого действия обратитесь к администратору</p>
            </div>
            <div class="modal-footer " >
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Конец модельное окно отсутствия прав-->

<div class="position-fixed bottom-0 end-0 p-3 single" style="z-index: 100000; margin-bottom: 3%;">

</div>
@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/CompanyCall.js',
    'resources/js/timeReload.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
