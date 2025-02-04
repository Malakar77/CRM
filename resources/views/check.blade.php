<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CRM AKСплав">
    <meta name="author" content="Data Jalagoniya d.jalagoniya@aksplav.ru">
    <meta name="generator" content="Hugo 0.122.0">
    <title>{{ env('APP_NAME_COMPANY', 'CRM') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sidebars/">

    <!-- Custom styles for this template -->
    <style>
        .selectize-control.single .selectize-input {
            box-shadow: none !important;
        }

        input[type=text]::placeholder {
            font-size: 13px;
            color: #495057;
        }

        input[type=text]::-webkit-input-placeholder {
            font-size: 13px;
            color: #495057;
        }

        input[type=text]::-moz-placeholder {
            font-size: 13px;
            color: #495057;
        }

        input[type=text]:-moz-placeholder {
            font-size: 13px;
            color: #495057;
        }

        input[type=text]:-ms-input-placeholder {
            font-size: 13px;
            color: #495057;
        }
        input[type=date]:-ms-input-placeholder {
            font-size: 13px !important;
            color: #495057;
        }

        label{
            font-size: 13px;
        }
        .id_sale > * {
            font-size: 13px !important;
            max-width: 150px;
        }

        .form-controls{
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            background-color: #212529;
            height: 40px;
        }

        .text_input{
            transition: width 1s ease;
        }

        .text_input:focus {
            height: 9em;
        }

        .text_input:not(:placeholder-shown){
            height: 9em;
        }

        /* context menu*/
        *,
        *:after,
        *:before {
            box-sizing: border-box;
        }


        .menu {
            display: flex;
            flex-direction: column;
            background-color: rgba(var(--bs-tertiary-bg-rgb),1) !important;
            border-radius: 10px;
            border: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
            z-index: 10;
            box-shadow: 0 0 10px 2px rgba(246, 246, 246, 0.2);
        }

        .menu-list {
            margin: 0;
            display: block;
            width: 100%;
            padding: 8px;
            & + .menu-list {
                border-top: 1px solid #ddd;
            }
        }
        .menu-sub-list {
            display: none;
            padding: 8px;
            background-color: var(--color-bg-secondary);
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(#404040, 0.15);
            position: absolute;
            left: 100%;
            right: 0;
            z-index: 100;
            width: 100%;
            top: 0;
            flex-direction: column;
            &:hover {
                display: flex;
            }
        }

        .menu-item {
            position: relative;
        }

        .menu-button {
            font: inherit;
            font-size: 13px;
            border: 0;
            padding: 8px 36px 8px 8px;
            width: 100%;
            border-radius: 8px;
            text-align: left;
            display: flex;
            align-items: center;
            position: relative;
        }

        li {
            list-style-type: none; /* Убираем маркеры */
        }


        .menu{
            -webkit-box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.2);
            -moz-box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.2);
            box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.2);
        }
        .context-menu {
            display: none;
            width: 24em;
        }

        .context-menu--active {
            display: flex ;
        }



        .task {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: solid 1px #dfdfdf;
        }

        .task:last-child {
            border-bottom: none;
        }

        .container
        .form_context{
            width: 20em;
            margin-bottom: 5px;
        }
        .label_context{
            width: 7em;
            margin-left: 1em;
            color: var(--bs-body-color);
        }
        #add{
            width: 13em;
            background-color: var(--bs-body-bg);
            border: var(--bs-border-width) solid var(--bs-border-color);
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            appearance: textfield;
        }

        #minus{
            width: 13em;
            background-color: var(--bs-body-bg);
            border: var(--bs-border-width) solid var(--bs-border-color);
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            appearance: textfield;
        }
        #add::placeholder{
            font-size: 13px;
            text-align: center;
        }
        #minus::placeholder{
            font-size: 13px;
            text-align: center;
        }
        #add:focus {
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }
        #minus:focus {
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13,110,253,.25);
        }
        .menu-button {
            background-color: #2b3035;
            &:hover {
                background-color: #495057;
            }
        }
        .temp12{
            width: 8em !important;
        }

        .table {
            border-collapse: collapse; /* Убираем соединение границ */
        }

        .table td {
            border: var(--bs-border-width) solid var(--bs-border-color); /* Убираем границы для ячеек таблицы */
            padding: 0; /* Убираем отступы */
        }

        .table input[type="text"],
        .table select,
        .table span {

            width: 100%; /* Заполняем ячейку полностью */
            border: none;  /* Добавляем границу, чтобы внешне они выглядели как элементы формы Bootstrap */
            border-radius: 0; /* Убираем скругления границ */
            height: calc(1.5em + .75rem + 2px); /* Выравниваем высоту с элементами формы Bootstrap */
            padding: .375rem .75rem; /* Добавляем отступы, чтобы соответствовать стилю Bootstrap */
            font-size: 1rem; /* Устанавливаем размер шрифта, чтобы соответствовать стилю Bootstrap */
            line-height: 1.5; /* Устанавливаем высоту строки, чтобы соответствовать стилю Bootstrap */
            display: inline-block; /* Делаем span блочным элементом */
        }

        .form-control:focus,
        .form-select:focus
        {
            z-index: 10;
            position: relative;
        }

        .form_group{
            font-size: 13px !important;
        }
        .form-control{
            font-size: 13px !important;
        }
        [data-bs-theme="dark"] .form-select {
            --bs-form-select-bg-img: none;
        }
        .form-select{
            text-align: center;
        }
        th{
            font-size: 13px;
        }
        .summa{
            font-size: 13px;
            padding: 5px 0 0 5px !important;
        }

        #textareaComment{
            height: 200px;
            resize: none;
        }
        .blockInfo{
            position: relative;
        }
        .infoText{
            position: absolute;
            top: 171px;
            left: 10px;
            color: #6c757d;
            font-size: 13px;
            z-index: 10;
        }

        textarea::placeholder{
            color: rgba(94, 94, 94, 0.75) !important;
        }

        th{
            height: 19px ;
        }
        tr{
            height: 35px;
        }
        #setAllCheckbox{
            font-size: 15px;
            color: #00ffd5;
        }

        #setAllCheckbox:hover{

            color: #42f805;
            filter: drop-shadow(1px 1px 1px #04f358);
        }

        tr:not(:last-child):hover td {
            background-color: rgba(108, 117, 125, 0.1);
        }

        tr:not(:last-child):hover span {
            background-color: rgba(108, 117, 125, 0.1);
        }

        tr:not(:last-child):hover input:not([type="checkbox"]) {
            background-color: rgba(108, 117, 125, 0.1);
        }

        tr:not(:last-child):hover select {
            background-color: rgba(108, 117, 125, 0.1);
        }


    </style>
</head>
<body>
<main class="d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 15%;">
        <div  class="container">
            <div class="row">
                <div class="col-3 ps-0">
                    <img src="{{ env('LOGO_CRM', '/icon/logo.svg') }}" alt="logo" style="width: 40px; margin-right: 15px;">
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
                    <div class="container-fluid d-grid gap-3 align-items-center " style="grid-template-columns: 1fr 2fr;">
                        <div class="d-flex align-items-center">
                            <h5 id="company"></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="body">
                <div class="row bg-body-tertiary border rounded-3 p-2 mb-3">
                        <div class="col ps-0 pe-0">
                            <div class="input-group">
                                <span class="input-group-text" style="font-size: 13px">№ Счета</span>
                                <button type="button" class="btn btn-outline-secondary" data-action="numberPlus" style="border-radius: unset; padding: 5px;">
                                    <i class="bi bi-plus" data-action="numberPlus"></i>
                                </button>
                                <input type="text" class="form-control " id="inputCheck" aria-label="#" data-action="numberCheck">
                            </div>
                        </div>
                        <div class="col pe-0" >
                            <div class="input-group">
                                <span class="input-group-text">Дата</span>
                                <button type="button" class="btn btn-outline-secondary addDate" data-action="day" style="border-radius: unset; padding: 5px;">
                                    <i class="bi bi-calendar-date" data-action="day"></i>
                                </button>
                                <input type="date" class="form-control date" id="data_check" aria-label="#">
                            </div>
                        </div>
                        <div class="col-4 pe-0">
                            <div class="input-group">
                                <span class="input-group-text">Компания</span>
                                <button type="button"
                                        class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a id="editFormBut"
                                           class="dropdown-item"
                                           type="button"
                                           data-bs-toggle="offcanvas"
                                           data-bs-target="#offcanvasEdit"
                                           aria-controls="offcanvasEdit"
                                           data-action="editCompanyProvider"
                                        >Редактировать</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            type="button"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasAdd"
                                            aria-controls="offcanvasAdd" >Добавить</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" data-action="deleteCompany">Удалить</a></li>
                                </ul>
                                <select type="text" id="selectCompany" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-4 pe-0">
                            <div class="input-group">
                                <input type="text" id="comment" class="form-control infoInput" placeholder="Комментарий к счету" aria-label="Комментарий к счету" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="commentBut" data-bs-toggle="modal" data-bs-target="#comment_model" data-action="inputComment">Добавить</button>
                            </div>
                        </div>
                </div>
                <div class="row bg-body-tertiary border rounded-3 p-2 mb-1" id="registerSubmit" oncontextmenu="return false;">
                    <div class="col pe-0 ps-0">
                        <div class="row">
                            <div class="col">
                                <form class="form" style="height: auto; overflow: auto; max-height: 72vh;">
                                    <table class="table table-bordered mb-0">
                                        <thead class="mb-3" style="position: sticky; top: 0;">
                                        <tr>
                                            <th style="width: 1%; text-align: center;">
                                                <div style="display: flex; justify-content: center; align-items: center; height: 19px;">
                                                    <i class="bi bi-check-lg" id="setAllCheckbox" data-action="setCheckbox"></i>
                                                </div>
                                            </th>
                                            <th style="width: 1%; text-align: center;">№</th>
                                            <th style="width: 33.3%;">Наименование</th>
                                            <th style="width: 3%; text-align: center;">Ед.из</th>
                                            <th style="width: 3.3%; text-align: center;">Количество</th>
                                            <th style="width: 7%; text-align: center;">Цена</th>
                                            <th style="width: 7%; text-align: center;">Сумма</th>
                                            <th style="width: 4%; text-align: center;">НДС</th>
                                            <th style="width: 7%; text-align: center;">Сумма ндс</th>
                                            <th style="width: 7%; text-align: center;">Итого с ндс</th>
                                        </tr>
                                        </thead>
                                        <tbody id="formKanban">
{{--                                        <tr class="kanban__item">--}}
{{--                                            <td style="height: 34px">--}}
{{--                                                <div style="display: flex; justify-content: center; align-items: center; height: 100%;">--}}
{{--                                                    <input class="form-check-input checkbox " type="checkbox" value="" style="margin: 0;" data-action="checkbox">--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                            <td><span class="form-control spanIndex">1</span></td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group position" name="name">--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <select class=" div3 form-select form_group position" name="unitOfMeasurement">--}}
{{--                                                    <option value="кг">кг</option>--}}
{{--                                                    <option value="т">т</option>--}}
{{--                                                    <option value="метр">метр</option>--}}
{{--                                                    <option value="м2">м²</option>--}}
{{--                                                    <option value="м2">м³</option>--}}
{{--                                                    <option value="шт">шт</option>--}}
{{--                                                    <option value="литр">литр</option>--}}
{{--                                                    <option value="упак">упак</option>--}}
{{--                                                </select>--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group count position" name="count" value="0.00" data-action="input">--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group price position" name="price" value="0.00" data-action="input">--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group sumPrice position" value="0.00" name="sumPrice">--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <select class="form-select form_group selectNds position" type="text" name="selectNds" data-action="selectNds">--}}
{{--                                                    <option value="no">Без НДС</option>--}}
{{--                                                    <option value="decrease" selected="">Выдел.</option>--}}
{{--                                                    <option value="increase">Начис.</option>--}}
{{--                                                </select>--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group sumNalog position" value="0.00" name="sumNalog">--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <input type="text" class="form-control form_group sumPosition position" value="0.00" name="sumPosition">--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
                                        <tr style="position: sticky; bottom: 0">
                                            <td colspan="3"></td>

                                            <td style="text-align: center; padding: 5px">Итого</td>
                                            <td class="summa totalSumCount">0.00</td>
                                            <td></td>
                                            <td class="summa totalSumPrice">0.00</td>
                                            <td></td>
                                            <td class="summa totalSumNds">0.00</td>
                                            <td class="summa sumCheck">0.00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="btn-group" id="blockSubmit" role="group" aria-label="Basic outlined example">
                                <button type="button" class="btn btn-outline-primary" data-action="addPosition">Добавить</button>
                                <button type="button" class="btn btn-outline-primary " data-action="ajaxPosition">Счет</button>
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
{{--добавление компании поставщика --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAdd" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Добавить компанию</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formAdd">
            <div class="mb-3">
                <label for="nameCompany" class="form-label">Название</label>
                <input type="text" class="form-control" id="nameCompany" placeholder="Название компании" name="nameCompany">
            </div>
            <div class=" mb-3">
                <label for="companyInn" class="form-label">ИНН</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="companyInn" name="companyInn" placeholder="Инн компании" aria-label="7751232801" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" data-action="searchCompany">Поиск</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="kppCompany" class="form-label">КПП</label>
                <input type="text" class="form-control" id="kppCompany" name="kppCompany" placeholder="КПП компании">
            </div>
            <div class="mb-3">
                <label for="addressCompany" class="form-label">Адрес</label>
                <textarea class="form-control" id="addressCompany" name="addressCompany" rows="3" style="resize: none;" placeholder="Адрес компании"></textarea>
            </div>
            <div class="mb-3">
                <label for="companyAccountNumber" class="form-label">Расчетный счет</label>
                <input type="text" class="form-control" id="companyAccountNumber" name="companyAccountNumber" placeholder="Рассчетный счет компании">
            </div>
            <div class=" mb-3">
                <label for="bikCompany" class="form-label">БИК</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="bikCompany" name="bikCompany" placeholder="БИК компании" aria-label="7751232801" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" data-action="searchBank">Поиск</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="nameBank" class="form-label">Банк</label>
                <input type="text" class="form-control" id="nameBank" name="nameBank" placeholder="Банк компании">
            </div>
            <div class="mb-3">
                <label for="corCheck" class="form-label">Кор.счет</label>
                <input type="text" class="form-control" id="corCheck" name="corCheck" placeholder="Кор. счет">
            </div>
            <button type="button" class="btn btn-outline-primary " data-action="addCompanyProvider">Добавить</button>
        </form>
    </div>
</div>

{{--Редактировать компанию поставщика --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Редактировать компанию</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formEdit">
            <div class="mb-3">
                <label for="nameEditCompany" class="form-label">Название</label>
                <input type="text" class="form-control" id="nameEditCompany" name="nameEditCompany" placeholder="Ак Сплав">
            </div>
            <div class=" mb-3">
                <label for="innEditCompany" class="form-label">ИНН</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="innEditCompany" name="innEditCompany" placeholder="7751232801" aria-label="7751232801" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" id="innSearchCompany" data-action="searchCompany">Поиск</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="kppEditCompany" class="form-label">КПП</label>
                <input type="text" class="form-control" id="kppEditCompany" name="kppEditCompany" placeholder="Ак Сплав">
            </div>
            <div class="mb-3">
                <label for="addressEditCompany" class="form-label">Адрес</label>
                <textarea class="form-control" id="addressEditCompany" rows="3" name="addressEditCompany" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
                <label for="editAccountNumber" class="form-label">Расчетный счет</label>
                <input type="text" class="form-control" id="editAccountNumber" name="editAccountNumber" placeholder="Ак Сплав">
            </div>
            <div class=" mb-3">
                <label for="bikEditCompany" class="form-label">БИК</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="bikEditCompany" name="bikEditCompany" placeholder="7751232801" aria-label="7751232801" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" id="bikSearchEdit" data-action="searchBank">Поиск</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="bankEdit" class="form-label">Банк</label>
                <input type="text" class="form-control" id="bankEdit" name="bankEdit" placeholder="Ак Сплав">
            </div>
            <div class="mb-3">
                <label for="correspondentAccount" class="form-label">Кор.счет</label>
                <input type="text" class="form-control" id="correspondentAccount" name="correspondentAccount" placeholder="Ак Сплав">
            </div>
            <button type="button" class="btn btn-outline-primary" data-action="updateCompany">Сохранить</button>
        </form>
    </div>
</div>

{{--Окно наценки или скидки--}}
<div class="container context-menu " id="context-menu" style="left: 412px; top: 72px; position: absolute; ">
    <div class="menu">
        <ul class="menu-list list">
            <div class="form_context">
                <label for="add" class="label_context"><i class="fa fa-upload" aria-hidden="true" style="margin-right: 5px; "></i>Наценка</label>
                <input type="number" id="add" class="plus" placeholder="Наценка в процентах" data-action="plus" >
            </div>
            <div class="form_context">
                <label for="minus" class="label_context"><i class="fa fa-download" aria-hidden="true" style="margin-right: 5px;"></i>Скидка</label>
                <input type="number" id="minus" placeholder="Скидка в процентах" class="minus" data-action="minus" >
            </div>
        </ul>
        <ul class="menu-list ">
            <li class="menu-item"><button class="menu-button menu-button--delete" data-action="deleteActivePosition"><i class="bi bi-trash" style="margin-right: 5px;" data-action="deleteActivePosition"></i>Удалить</button></li>
        </ul>
    </div>
</div>

{{--Окно ввода комментария--}}
<div class="modal fade" id="comment_model" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Комментарий</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 blockInfo">
                    <textarea class="form-control" id="textareaComment" rows="3" data-action="countTextarea" data-enter="setCaret"></textarea>
                    <div class="infoText" id="textareaText">Введено 0 из 255 символов </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-action="saveComment">Сохранить изменения</button>
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
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/check.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
