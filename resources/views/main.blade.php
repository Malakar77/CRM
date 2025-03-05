<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite([ 'resources/css/main.css', 'resources/css/sidebars.css',])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
</head>
<body>
<main class="d-flex flex-nowrap">
    @include('sidebar')
    <div class="b-example-divider b-example-vr"></div>
    <div class="container-block">
        <div class="body mt-3">
            <div class="row">
                <!-- Левая колонка (калькулятор) -->
                <div class="col-12 col-md-8">
                    <div class="d-grid gap-3">
                        <div class="bg-body-tertiary border rounded-3" style="overflow-y: auto">
                            <iframe
                                id="myIframe"
                                width="100%"
                                height="550px"
                                src="/metal_calculator-master/culc.html"
                                title="Калькулятор металла">
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 todo">
                    <div class="d-grid gap-3">
                        <div class="bg-body-tertiary border rounded-3">
                            <div class="row">
                                <div class="col title_todo">
                                    <h6 class="header_todo">Активные задания</h6>
                                </div>
                                <div id="active_todo_list" class="rounded-3" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 col-md-8">
                    <div class="p-3 bg-body-tertiary border rounded-3" style="max-height: 90vh; overflow: scroll">
                        <div class="row todo_header mb-1">
                            <div class="col title_todo ">
                                <h6 class="align-middle mb-0" style="border-bottom: 1px solid #f0f1f2; width: 50%;">Календарь</h6>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-primary" id="delete-event" style="float: right"><i class="bi bi-trash"></i></button>
                                <button class="btn btn-outline-primary me-1" style="float: right" data-action="addTodo" ><i data-action="addTodo" class="bi bi-calendar-plus"></i></button>
                            </div>
                        </div>
                        <div id='calendar'></div>
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

<div class="modal fade" id="todoModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Редактирование Задания</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="textTodo" spellcheck="true" lang="ru" rows="3" style="height: 100px"></textarea>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-action="setTodo">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/main.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])

</body>
</html>
