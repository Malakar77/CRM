<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/manager.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

</head>
<body>

<main class="d-flex flex-nowrap">
    @include('sidebar')

    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block" data-action="clear">
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" class="form-control search" placeholder="Search..." aria-label="Search" name="search" value="" data-action="searchChange" data-enter="searchChange">
                            </form>
                        </div>
                        <div class="col-7 col-md-10">
                            <button type="button" class="btn btn-outline-primary btn-desktop" data-action="modal">
                                <i class="bi bi-plus-circle" data-action="modal"></i>
                                Добавить
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-mobile" data-action="modal">
                                <i class="bi bi-plus-circle" data-action="modal"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row justify-content-start">
                <div class="col-12">
                    <div class="">
                        <table class="table table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Компания</th>
                                <th scope="col">Имя менеджера</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Email</th>
                                <th scope="col"><i class="bi bi-person-gear"></i></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="paginator" style="position: relative">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-items-center justify-content-center paginatorNav" style="align-items: center; justify-content: center; margin: 0 auto; display: flex;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@include('theme')


<!-- Модальное окно -->
<div class="modal fade" id="addManager" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Добавить менеджера</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="add" data-action="validate">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Название Компании</label>
                        <select id="companyProvider" class="companyProvider" name="companyProvider"></select>
                    </div>
                    <div class="mb-3">
                        <label for="addNameManager" class="form-label">Имя Компании</label>
                        <input  type="text" class="form-control addNameManager" id="addNameManager" placeholder="Иванов И.И" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="addPhone" class="form-label">Номер телефона</label>
                        <input type="text"  class="form-control addPhone" id="addPhone" placeholder="+7 999 999 99 99" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email"  class="form-control addEmail" id="addEmail" placeholder="Email" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" id="submit" class="btn btn-primary" data-action="add" disabled>Добавить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editManager" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 nameCompany" id="staticBackdropLabel">Редактирование менеджера</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form id="edit" data-action="validate">
                    <div class="mb-3">
                        <label for="editNameManager" class="form-label">Имя Менеджера</label>
                        <input  type="text" class="form-control editNameManager" id="editNameManager" placeholder="Иванов И.И" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Номер телефона</label>
                        <input type="text"  class="form-control editPhone" id="editPhone" placeholder="+7 999 999 99 99" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email"  class="form-control editEmail" id="editEmail" placeholder="Email" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" id="submit" class="btn btn-primary" data-action="editButton">Редактировать</button>
            </div>
        </div>
    </div>
</div>


<!--модельное окно ошибки-->
@include('error')

<!--Конец модельное окно ошибки-->

@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/ManagerController.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
