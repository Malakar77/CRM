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
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 15%;">
        <div  class="container">
            <div class="row">
                <div class="col-3 ps-0">
                    <img src="{{ env('LOGO_CRM', 'icon/logo.svg') }}" alt="logo" style="width: 40px; margin-right: 15px;">
                </div>
                <div class="col-9 ps-0 block-name-company">
                    <span class="name-company" data-text="АК Сплав">{{ env('APP_NAME_COMPANY', 'CRM') }}</span>
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
  overflow: hidden;" >{{ Auth::user()->name }}</strong>
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
                <div class="col-3 mb-3">
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
                <div class="col-9  mb-3 result-blocks" style="height: 90vh; overflow: scroll;">

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
                Picture
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
    'resources/js/cool.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',

        ])
</body>
</html>
