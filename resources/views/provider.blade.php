<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/provider.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
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
        .bi-pencil:hover{
            color: #ffcc00;
        }

        tr:hover td {
            background-color: #0a5cae;
        }
        .categories:hover{
            background-color: #0a5cae;
        }

        .bi-trash:hover{
            color: #dc1313;
        }
    </style>

    <!-- Custom styles for this template -->

</head>
<body>

<main class="d-flex flex-nowrap">
    @include('sidebar')

    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" class="form-control search" placeholder="Search..." aria-label="Search" name="search" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row justify-content-start">
                <div class="col-12 col-md-2">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary add-user" data-action="add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            Добавить
                        </button>
                    </div>
                    <div class="list-group mt-1" id="catalog" style="overflow: scroll; height: 80vh;">

                    </div>
                </div>
                <div class="col-12 col-md-10 table_content">
                    <div class="">
                        <table class="table table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Компания</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Сайт</th>
                                <th scope="col">Город</th>
                                <th scope="col" style="text-align: end;"><i class="bi bi-person-gear"></i></th>
                            </tr>
                            </thead>
                            <tbody id="providers">

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
<div class="modal fade" id="formModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить Поставщика</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

@include('theme')

<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Удалить</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-outline-danger delete" data-action="delete">Удалить</button>
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
    'resources/js/provider.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
