<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/setting.css'])
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
        <div class="head">
            <div class="row">
                <div class="py-3 mb-3 border-bottom">
                    <div class="container-fluid d-grid gap-3 ">
                        <div class="d-flex justify-content-end">
                            <div class="row">
                                <div class="col">
                                    <i class="bi bi-save" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Сохранить" data-click="save"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body mt-3" data-id="{{Auth::user()->id}}">
            <div class="row">
                <div class="col-4 ps-0 pe-0">
                    <div class="bg-body-tertiary border rounded-3">
                        <div class="row">
                            <div class="col">
                                <img src="" alt="profile photo" id="photo" class="photo_user">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 ms-3 col_text">
                                <p>Ф.И.О.</p>
                            </div>
                            <div class="col-8 ms-3">
                                <select class="form-select" aria-label="" id="nameAllUser" data-change="userSelection">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 ms-3">
                                <p>Отдел</p>
                            </div>
                            <div class="col-8 ms-3">
                                <p class="post" id="post"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 ms-3">
                                <p>Должность</p>
                            </div>
                            <div class="col-8 ms-3">
                                <p class="post" id="youth"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col mt-2">
                        <div class="bg-body-tertiary border rounded-3">
                            <div class="row ">
                                <div class="col ms-3 mt-1 ">
                                    <h5 class="header header_plus">Должность</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 p-3 pb-0">
                                    <div class="row">
                                        <div class="col" ><label>Отдел</label></div>
                                        <div class="col plus"><i class="bi bi-plus-lg" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Добавить" data-click="add"></i></div>
                                    </div>
                                    <select class="form-select" aria-label="Default select example" id="department" >
                                        <option selected value="1">Не выбрано</option>
                                    </select>
                                </div>
                                <div class="col-12 p-3 ">
                                    <div class="row">
                                        <div class="col"><label>Должность</label></div>
                                        <div class="col plus"><i class="bi bi-plus-lg" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Добавить" data-click="add"></i></div>
                                    </div>
                                    <select class="form-select" aria-label="Default select example" id="post_user">
                                        <option selected value="1">Не выбрано</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8 ps-2">
                    <div class="bg-body-tertiary border rounded-3">
                        <div class="row ">
                            <div class="col ms-3 mt-1 ">
                                <h5 class="header">Права доступа</h5>
                            </div>
                        </div>
                        <div class="row ms-1">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="admin">
                                    <label class="form-check-label" for="admin">
                                        Администратор
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="work">
                                    <label class="form-check-label" for="work">
                                        Работает
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" >
                        <div class="col">
                            <div class="bg-body-tertiary border rounded-3">
                                <div class="row ">
                                    <div class="col ms-3 mt-1 ">
                                        <h5 class="header">Данные счетов</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="prefix" class="form-label">Префикс</label>
                                            <input type="text" class="form-control" id="prefix" placeholder="ДДМ" value="">
                                        </div>
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="numberCheck" class="form-label">Номер счета</label>
                                            <input type="text" class="form-control" id="numberCheck" placeholder="100" value="">
                                        </div>
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="numberContract" class="form-label">Номер договора</label>
                                            <input type="text" class="form-control" id="numberContract" placeholder="100" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" >
                        <div class="col">
                            <div class="bg-body-tertiary border rounded-3">
                                <div class="row ">
                                    <div class="col ms-3 mt-1 ">
                                        <h5 class="header " style="width: 25%;">Заработная плата</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="salary" class="form-label">Оклад</label>
                                            <input type="text" class="form-control" id="salary" value="">
                                        </div>
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="bonus_do" class="form-label">Премия до плана %</label>
                                            <input type="text" class="form-control" id="bonus_do" value="">
                                        </div>
                                        <div class=" ms-2 me-2 mb-2">
                                            <label for="bonus_after" class="form-label">Премия после плана %</label>
                                            <input type="text" class="form-control" id="bonus_after" value="">
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

<!-- Modal -->
<div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Добавить</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" id="post_type">
                        <option selected value="post">Отдел</option>
                        <option value="department">Должность</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="add_name" class="form-label">Название</label>
                    <input type="text" class="form-control" id="add_name" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-click="save_post">Сохранить</button>
            </div>
        </div>
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


@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/setting.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
