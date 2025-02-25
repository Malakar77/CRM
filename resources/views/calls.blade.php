<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/call.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRM AKСплав">
    <meta name="author" content="Data Jalagoniya d.jalagoniya@aksplav.ru">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <style>
        .bg-body-tertiary{
            opacity: 0.9;
        }

    </style>
</head>
<body>

<main class="d-flex flex-nowrap">
    @include('sidebar')

    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block" >
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <form class="w-100 me-3" role="search">
                                <input type="search" class="form-control" id="search" placeholder="Search..." aria-label="Search" name="search" value="" data-action="search" data-enter="search">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row justify-content-start">
                <div class="col-12 col-md-3 mb-3 company_list">
                    <div class="d-grid gap-3 ">
                        <div class="bg-body-tertiary border rounded-3 p-2" style="height: 91vh;">
                            <div class="mb-3 col-12 h-100" style="overflow: scroll;">
                                <table class="table table-hover">
                                    <thead class="sticky-top">
                                    <tr>
                                        <th>Компания</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableCompany"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9  mb-3 result-blocks" style="height: 90vh; overflow: scroll;">

                </div>
            </div>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-relative tost" >
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
            <!-- Тосты -->
        </div>
    </div>


</main>


@include('theme')

<!--модельное окно ошибки-->

<!-- Modal -->
<div class="modal fade" id="todoModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Добавление Задания</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="textTodo" spellcheck="true" lang="ru" rows="3" style="height: 100px" data-action="countTodo"></textarea>
                            <label for="floatingTextarea2">Введите текст задания</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class=" form-label">Дата</label>
                        <input type="datetime-local" class="form-control" name="date" id="todoDate">
                    </div>
                    <div class="col-12" style="min-height: 25px">
                        <span id="errorTodo"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-action="setTodo">Understood</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="sentMassage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="formEmail" data-offer="true" data-card="true">
                <div class="mb-3 row">
                    <label for="emailCompany" class="col-sm-1 col-form-label">Кому:</label>
                    <div class="col-sm-11">
                        <input type="email" class="form-control" id="emailCompany">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emailUser" class="col-sm-1 col-form-label">От:</label>
                    <div class="col-sm-11">
                        <input type="email" class="form-control" id="emailUser" value="{{\Illuminate\Support\Facades\Auth::user ()->login}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="subject" class="col-sm-1 col-form-label">Тема:</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="subject" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="textEmail" class="form-label">Текст сообщения:</label>
                    <textarea class="form-control" id="textEmail" spellcheck="true" lang="ru" rows="3" data-enter="setCaret" style="height: 400px;">

                    </textarea>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <span>Прикрепить фаил</span>
                            <input type="file" class="form-control" id="fileInput">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row" id="offer">
                        <div class="col-6 offer_pdf">
                            <i class="bi bi bi-filetype-pdf" style="color: red; font-size: 25px"></i>
                            <span class="nameFile">Коммерческое предложение.pdf</span>
                            <span class="sizeFile ms-1" style="color: #94999d">403.2 Kb</span>
                            <i class="bi bi-x-lg" data-action="deleteOffer" ></i>
                        </div>
                        <div class="col-6 card_company">
                            <i class="bi bi bi-filetype-pdf" style="color: red; font-size: 25px"></i>
                            <span class="nameFile">Карточка организации.pdf</span>
                            <span class="sizeFile ms-1" style="color: #94999d">458.1 kb</span>
                            <i class="bi bi-x-lg" data-action="deleteCardCompany"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-action="sentEmail">Send message</button>
            </div>
        </div>
    </div>
</div>



@include('error')

<!--Конец модельное окно ошибки-->

@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/cool.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',

        ])
</body>
</html>
