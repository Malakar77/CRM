<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/check_total.css'])
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
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
        .container-block{
            width: 100%;
            padding: 0px 20px 20px 20px;
            height: 100vh; /* установите высоту контейнера по высоте окна браузера (100% высоты экрана) */
        }
        .invoicePreview {
            position: relative;

            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: black;
        }

        .invoicePreview__company-block {
            width: 60%;
        }

        .invoicePreview__company-block .invoicePreview__company-name {
            font-weight: 700;
        }

        .invoicePreview__company-block .invoicePreview__company-address,
        .invoicePreview__company-block .invoicePreview__company-phone {
            margin-top: 10px;
        }

        .invoicePreview__logo-block {
            position: absolute;
            top: -16px;
            right: 0;
        }

        .invoicePreview__logo-block .invoicePreview__logo-change-block {
            text-align: right;
        }

        .invoicePreview__logo-block .invoicePreview__logo-change-block .invoicePreview__logo-wrapper {
            height: 100px;
            width: 200px;
            vertical-align: middle;
            display: table-cell;
            overflow: hidden;
            font-size: 0;
        }

        .invoicePreview__logo-block .invoicePreview__logo-change-block .invoicePreview__logo-wrapper .invoicePreview__logo {
            max-height: 75px;
            width: auto;
        }

        .invoicePreview__bank-details-block {
            margin-top: 20px;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details-sample {
            font-size: 11px;
            padding-bottom: 5px;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details {
            table-layout: fixed;
            border-collapse: collapse;
            width: 100%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details td {
            border: 1px solid #d9d9d9;
            padding: 5px;
            position: relative;
            vertical-align: top;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details td.with-description {
            padding-bottom: 22px;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details td.description {
            font-size: 12px;
            padding-top: 7px;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__table-layout td {
            border: none;
            padding: 0;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-bank-name {
            width: 60%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-bank-bik {
            width: 8%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-bank-bik-number {
            width: 32%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-id,
        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-kpp {
            width: 8%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-id-number,
        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-kpp-number {
            width: 22%;
        }

        .invoicePreview__bank-details-block .invoicePreview__bank-details .invoicePreview__bank-details-description {
            position: absolute;
            bottom: 5px;
            left: 5px;
            font-size: 11px;
        }

        .invoicePreview__invoice-number {
            padding: 20px 0;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }

        .invoicePreview__recipient,
        .invoicePreview__supplier {
            padding-bottom: 5px;
        }

        .invoicePreview__items-block {
            padding-top: 25px;
        }

        .invoicePreview__items-block .invoicePreview__items {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        .invoicePreview__items-block .invoicePreview__items td,
        .invoicePreview__items-block .invoicePreview__items th {
            border: 1px solid #e0e0e0;
            box-sizing: border-box;
            padding: 0px 8px;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header th {
            font-weight: 400;
            text-align: left;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-number {
            width: 2em;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-count {
            width: 5em;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-price,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-total {
            width: 8em;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-count,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-price,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-header .invoicePreview__items-header-total,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-items .invoicePreview__items-items-count,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-items .invoicePreview__items-items-price,
        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-items .invoicePreview__items-items-total {
            text-align: right;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-total td {
            border: none;
            height: 24px;
            text-align: right;
        }

        .invoicePreview__items-block .invoicePreview__items .invoicePreview__items-total .super-total-row {
            font-weight: 700;
        }

        .invoicePreview__comment {
            position: relative;
            z-index: 10;
            padding-top: 25px;
        }

        .invoicePreview__sign {
            padding: 60px 0 80px;
            position: relative;
        }

        .invoicePreview__sign .invoicePreview__sign-name,
        .invoicePreview__sign .invoicePreview__sign-placeholder,
        .invoicePreview__sign .invoicePreview__sign-position {
            position: relative;
            z-index: 1;
            display: inline-block;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder {
            width: 220px;
            margin: 0 10px;
            color: transparent;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder:after {
            display: block;
            content: " ";
            position: absolute;
            left: 0;
            right: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.2);
            z-index: 5;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-sign-block {
            position: absolute;
            left: 40px;
            bottom: 100%;
            margin-bottom: -10px;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-sign-block .invoicePreview__sign-sign {
            position: absolute;
            bottom: 100%;
            margin-bottom: -30px;
            left: -20px;
            max-width: 200px;
            max-height: 100px;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-sign-block.loaded .invoicePreview__sign-sign-upload {
            display: none;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-stamp-block {
            position: absolute;
            left: 40px;
            top: 100%;
            margin-top: 8px;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-stamp-block .invoicePreview__sign-stamp {
            position: absolute;
            max-width: 250px;
            max-height: 250px;
            margin-top: -90px;
            left: 60px;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-stamp-block.loaded .invoicePreview__sign-stamp-upload {
            display: none;
        }

        .invoicePreview__sign .invoicePreview__sign-placeholder .invoicePreview__sign-stamp-block .invoicePreview__sign-stamp-upload {
            width: 145px;
        }

        .invoicePreview__sign .invoicePreview__sign-sign-change,
        .invoicePreview__sign .invoicePreview__sign-stamp-change {
            position: absolute;
            right: 0;
            display: none;
            width: 145px;
        }

        .invoicePreview__sign .invoicePreview__sign-sign-change.loaded,
        .invoicePreview__sign .invoicePreview__sign-stamp-change.loaded {
            display: inline-block;
        }

        .invoicePreview__sign .invoicePreview__sign-sign-change {
            top: 40px;
        }

        .invoicePreview__sign .invoicePreview__sign-stamp-change {
            bottom: 50px;
        }

        .invoicePreview__logo-select-file,
        .invoicePreview__sign-select-file,
        .invoicePreview__stamp-select-file {
            display: none;
        }

        .statusSelector {
            display: inline-block;
            font-size: 0;
        }

        .statusSelector__item {
            display: inline-block;
            width: 120px;
            font-size: 15px;
            text-align: center;
            border: 1px solid #cbd2d6;
            box-sizing: border-box;
            padding: 9px 0;
            margin-left: -1px;
            cursor: pointer;
        }

        .statusSelector__item:hover {
            background-color: #f7f7f5;
        }

        .statusSelector__item.selected {
            position: relative;
            border: none;
            padding: 10px 0;
            color: #fff;
        }

        .statusSelector__item.status-new.selected {
            box-shadow: 0 3px 0 0 #546877 inset;
            background-color: #667c8d;
        }

        .statusSelector__item.status-paid.selected {
            box-shadow: 0 3px 0 0 #00a358 inset;
            background-color: #00c269;
        }

        .statusSelector__item.status-unpaid.selected {
            box-shadow: 0 3px 0 0 #be0000 inset;
            background-color: red;
        }

        .statusSelector.waiting .statusSelector__item.selected {
            background-image: url();
            background-repeat: no-repeat;
            background-position: 50% 49%;
            color: transparent;
        }

        .statusSelector__item:first-child {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .statusSelector__item:last-child {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        .statusButton,
        .statusButton__button {
            position: relative;
            display: inline-block;
        }

        .statusButton__button {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: 9px 40px 10px 20px;
            background-color: #0d7bde;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }

        .statusButton__button.status-new {
            background-color: #a5a5a5;
        }

        .statusButton__button.status-new:hover {
            background-color: #9b9b9b;
        }

        .statusButton__button.status-sent {
            background-color: #0d7bde;
        }

        .statusButton__button.status-sent:hover {
            background-color: #0b72cf;
        }

        .statusButton__button.status-viewed {
            background-color: #810aef;
        }

        .statusButton__button.status-viewed:hover {
            background-color: #780cdd;
        }

        .statusButton__button.status-paid {
            background-color: #00c269;
        }

        .statusButton__button.status-paid:hover {
            background-color: #00b260;
        }

        .statusButton__button.status-unpaid {
            background-color: red;
        }

        .statusButton__button.status-unpaid:hover {
            background-color: #e90000;
        }

        .statusButton__button .statusButton__button-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            margin-top: -3px;
            margin-left: -5px;
            fill: currentColor;
        }

        .statusButton__dropdown {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            width: 120px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            border-radius: 3px;
        }

        .statusButton__dropdown.visible {
            display: block;
        }

        .statusButton__dropdown .statusButton__dropdown-item {
            padding: 10px 5px 10px 20px;
            cursor: pointer;
        }

        .statusButton__dropdown .statusButton__dropdown-item.status-new {
            border-radius: 3px 3px 0 0;
            color: #a5a5a5;
        }

        .statusButton__dropdown .statusButton__dropdown-item.status-sent {
            color: #0d7bde;
        }

        .statusButton__dropdown .statusButton__dropdown-item.status-viewed {
            color: #810aef;
        }

        .statusButton__dropdown .statusButton__dropdown-item.status-paid {
            color: #00c269;
        }

        .statusButton__dropdown .statusButton__dropdown-item.status-unpaid {
            border-radius: 0 0 3px 3px;
            color: red;
        }

        .statusButton__dropdown .statusButton__dropdown-item:hover {
            background-color: #f3f9ff;
        }

        .invoiceView {
            position: relative;
            padding: 20px 90px 0;
        }

        .invoiceView__actions-back {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            position: absolute;
            top: 36px;
            left: 30px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            border-radius: 40px;
            background-color: transparent;
            transition: background-color 0.3s;
        }

        .invoiceView__actions-back:hover {
            border-radius: 40px;
            background-color: #e7e7e7;
            transition: none;
        }

        .invoiceView__actions-back:active {
            background-color: #d3d3d3;
            transition: none;
        }

        .invoiceView__actions-back svg {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -10px;
            margin-left: -8px;
        }

        .invoiceView__header {
            margin-bottom: 10px;
        }

        .invoiceView__details {
            font-size: 18px;
            color: #999;
        }

        .invoiceView__actions {
            margin-top: 30px;
        }

        .invoiceView__actions-download,
        .invoiceView__actions-edit,
        .invoiceView__actions-send,
        .invoiceView__actions-status {
            margin-right: 20px;
        }

        .invoiceView__content {
            margin-top: 40px;
            width: 860px;
            padding: 80px;
            margin-bottom: 80px;
            box-sizing: border-box;
            box-shadow: 0 1px 8px -3px;
            background-color: #fff;
        }

        .publicInvoice {
            position: relative;
            min-height: 100%;
        }

        .publicInvoice__content {
            background-color: #fff;
            width: 860px;

            padding: 40px 110px 30px 40px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        #print {
            margin-bottom: 4rem;
            border: 2px solid hsl(216, 5%, 60%);
            padding: 1rem;
            text-align: center;
            font-family: sans-serif;
        }

        #print button {
            padding: 0.5rem 1rem;
        }

        #print p {
            margin: 0;
        }



        .loader {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: rotateZ(45deg);
            perspective: 1000px;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            color: #ea0505;
            z-index: 10000;
        }
        .loader:before,
        .loader:after {
            content: '';
            display: block;
            position: absolute;
            top: 1px;
            left: -10px;
            width: inherit;
            height: inherit;
            border-radius: 50%;
            transform: rotateX(70deg);
            animation: 1s spin linear infinite;
        }
        .loader:after {
            color: #1de805;
            transform: rotateY(70deg);
            animation-delay: .4s;
        }

        @keyframes rotate {
            0% {
                transform: translate(-50%, -50%) rotateZ(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotateZ(360deg);
            }
        }

        @keyframes rotateccw {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }

        @keyframes spin {
            0%,
            100% {
                box-shadow: .2em 0px 0 0px currentcolor;
            }
            12% {
                box-shadow: .2em .2em 0 0 currentcolor;
            }
            25% {
                box-shadow: 0 .2em 0 0px currentcolor;
            }
            37% {
                box-shadow: -.2em .2em 0 0 currentcolor;
            }
            50% {
                box-shadow: -.2em 0 0 0 currentcolor;
            }
            62% {
                box-shadow: -.2em -.2em 0 0 currentcolor;
            }
            75% {
                box-shadow: 0px -.2em 0 0 currentcolor;
            }
            87% {
                box-shadow: .2em -.2em 0 0 currentcolor;
            }
        }
        td{
            font-size: small;
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
                    <div class="container-fluid d-grid gap-3 " >
                        <div class="d-flex justify-content-end">
                            <ul class="nav ">
                                <li class="nav-item " >
                                    <a class="nav-link active printBut" aria-current="page" data-click="print">
                                        <i class="bi bi-printer" data-click="print"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link downloadFile" data-click="download">
                                        <i class="bi bi-download" data-click="download"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link checkExel" data-click="xlsx">
                                        <i class="bi bi-filetype-xlsx" data-click="xlsx"></i>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link editCheck" data-click="edit">
                                        <i class="bi bi-vector-pen" data-click="edit"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sentFile" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-click="modalSentMail">
                                        <i class="bi bi-envelope-arrow-up" data-click="modalSentMail"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row bg-body-tertiary border rounded-3 p-2 mb-3">
                <div class="body">
                    <div class="row">
                        <div class="container " >
                            <div class="d-grid gap-3" style="">
                                <div class="publicInvoice ">

                                    <div class="publicInvoice__content" id="invoice" style="overflow: scroll;
  height: 90vh;">
                                        <div class="invoicePreview " style="width: 788px;">
                                            <div class="invoicePreview__company-block">
                                                <img src="/images/ISO.png" style="width: 77px;">
                                            </div>
                                            <div class="invoicePreview__logo-block">
                                                <div class="invoicePreview__logo-change-block">
                                                    <div class="invoicePreview__logo-wrapper">
                                                        <img src="/images/Logo.jpg" class="invoicePreview__logo" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invoicePreview__bank-details-block">
                                                <div class="invoicePreview__bank-details-sample">
                                                    Образец заполнения платежного поручения
                                                </div>
                                                <table class="invoicePreview__bank-details">
                                                    <tbody>
                                                    <tr>
                                                        <td rowspan="2" colspan="4"
                                                            class="invoicePreview__bank-details-bank-name with-description">
                                                            <span id="bank-name">{{$headers['bank']}}</span>
                                                            <div class="invoicePreview__bank-details-description">
                                                                Банк получателя
                                                            </div>
                                                        </td>
                                                        <td class="invoicePreview__bank-details-bank-bik description">
                                                            БИК
                                                        </td>
                                                        <td class="invoicePreview__bank-details-bank-bik-number">
                                                            <span id="bank-bik">{{$headers['bik_bank_company']}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="description">Сч. №</td>
                                                        <td>
                                                            <span id="bank-account">{{$headers['ras_chet']}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="invoicePreview__bank-details-id description">
                                                            ИНН
                                                        </td>
                                                        <td class="invoicePreview__bank-details-id-number">
                                                            <span id="company-inn">{{$headers['inn_company']}}</span>
                                                        </td>
                                                        <td class="invoicePreview__bank-details-kpp description">
                                                            КПП
                                                        </td>
                                                        <td class="invoicePreview__bank-details-kpp-number">
                                                            <span id="company-kpp">{{$headers['kpp_company']}}</span>
                                                        </td>
                                                        <td rowspan="2" class="description">
                                                            Сч. №
                                                        </td>
                                                        <td rowspan="2">
                                                            <span id="company-account">{{$headers['kor_chet']}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: rgba(255,255,255,0);" rowspan="2" colspan="4" class="with-description">
                                                            <span  id="company-name-2">{{$headers['company_name']}}</span>
                                                            <div style="background-color: rgba(255,255,255,0);" class="invoicePreview__bank-details-description">
                                                                Получатель
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="invoicePreview__invoice-number">
                                                Счет на оплату № <span id="invoice-number">{{$headers['number_check']}}</span> от <span id="invoice-date">{{$headers['date_check']}}</span><br>
                                                <span id="invoice-number" class="comment_text" style="font-size: 12px; white-space: normal;width: 70%; display: block; margin: 0 auto;">{!! $headers['comment'] !!}</span>
                                            </div>
                                            <div class="invoicePreview__supplier">
                                                Поставщик: <span id="company-name-3">{{$headers['company_name']}}</span>,
                                                <span id="company-address-2">{{$headers['ur_address_company']}}</span>
                                            </div>
                                            <div class="invoicePreview__recipient">
                                                Покупатель: <span id="recipient">{{$headers['name']}} ИНН {{$headers['inn']}} {{$headers['address']}}</span>
                                            </div>
                                            <div class="invoicePreview__items-block">
                                                <table class="invoicePreview__items">
                                                    <thead class="invoicePreview__items-header">
                                                    <tr>
                                                        <th class="invoicePreview__items-header-number p-1" >
                                                            №
                                                        </th>
                                                        <th class="invoicePreview__items-header-item p-1"  style="width: 20em">
                                                            Товар или услуга
                                                        </th>
                                                        <th class="invoicePreview__items-header-count p-1" style="width: 4em;">
                                                            Ед.из
                                                        </th>
                                                        <th class="invoicePreview__items-header-count p-1" style="width: 5em;">
                                                            Кол-во
                                                        </th>

                                                        <th class="invoicePreview__items-header-price p-1" style="width: 5em;">
                                                            Цена
                                                        </th>

                                                        <th class="invoicePreview__items-header-total p-1" style="width: 3em; text-align: right;">
                                                            НДС
                                                        </th>
                                                        <th class="invoicePreview__items-header-total p-1" style="text-align: right;">
                                                            Сумма НДС
                                                        </th>
                                                        <th class="invoicePreview__items-header-total p-1" style="text-align: right;">
                                                            Всего с НДС
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="invoicePreview__items-items">

                                                    @foreach($headers['position'] as $key)
                                                        <tr>
                                                            <td class="p-1">{{$key['i']}}</td>
                                                            <td class="p-1">{{$key['name']}}</td>
                                                            <td class="p-1" style="text-align: center">{{$key['unit']}}</td>
                                                            <td class="p-1" style="text-align: end">{{$key['count']}}</td>
                                                            @php
                                                                $price = (int) $key['price'] * 10000000;
                                                                $totalPrice = ($price - ($price * 20 / 120)) / 10000000;
                                                                $value = number_format($totalPrice, 2, '.', ' ');
                                                            @endphp
                                                            <td class="p-1" style="text-align: end">{{$value}}</td>
                                                            <td class="p-1" style="text-align: center">{{$key['nds']}}</td>
                                                            <td class="p-1" style="text-align: end">{{$key['sum_nds']}}</td>
                                                            <td class="p-1" style="text-align: end">{{$key['result']}}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td style="background-color: #ffffff;" colspan=" 3 ">Итого</td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count  total_count" >

                                                        </td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count ">

                                                        </td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count  total_nds ">
                                                            {{$headers['totalSumNds']}}
                                                        </td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count  total_check">
                                                            {{$headers['totalResult']}}
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                    <tbody class="invoicePreview__items-total">
                                                    <tr>
                                                        <td style="background-color: #ffffff;" colspan=" 3 "></td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count  total_count" >

                                                        </td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count ">

                                                        </td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count  ">

                                                        </td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-items-count ">

                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                    <tbody class="invoicePreview__items-total">

                                                    <tr>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>

                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;">Итого</td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-total-total  total_check">
                                                            {{$headers['totalResult']}} руб
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>

                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;" colspan="2" class="invoicePreview__items-total-tax ">
                                                            Сумма НДС
                                                        </td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-total-total with-tax  total_nds">
                                                            {{$headers['totalSumNds']}} руб
                                                        </td>
                                                    </tr>
                                                    <tr class="super-total-row">
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>

                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;"></td>
                                                        <td style="background-color: #ffffff;">Всего</td>
                                                        <td style="background-color: #ffffff;" class="invoicePreview__items-total-total invoicePreview__items-super-total  total_check">
                                                            {{$headers['totalResult']}} руб
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="invoicePreview__comment  sumText" style="padding-top: 0">
                                                Сумма прописью:
                                                {{ \App\Services\UtilityHelper\UtilityHelper::mb_ucfirst(\App\Services\UtilityHelper\UtilityHelper::num2str($headers['totalResult'])) }} в т. ч. НДС 20% - {{ $headers['totalSumNds'] }} руб
                                            </div>
                                            <div class="invoicePreview__sign" style="padding-top: 40px; padding-bottom: 0;width: 70%;margin: 0 auto;">
                                                <div class="invoicePreview__sign-position">
                                                    Генеральный директор
                                                </div>
                                                <div class="invoicePreview__sign-placeholder">
                                                    (подпись)
                                                    <div class="invoicePreview__sign-sign-block">
                                                        <div class="invoicePreview__sign-sign-wrapper">
                                                            <img src="/images/Подпись.png" class="invoicePreview__sign-sign" />
                                                        </div>
                                                    </div>
                                                    <div class="invoicePreview__sign-stamp-block">
                                                        <div class="invoicePreview__sign-stamp-wrapper">
                                                            <img src="/images/Печать.png" class="invoicePreview__sign-stamp" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invoicePreview__sign-name">
                                                    <span id="manager">Аксендлер Александр Семенович</span>
                                                </div>
                                            </div>
                                            <div class="invoicePreview__sign" style="padding-top: 40px; padding-bottom: 0;width: 70%; margin: 0 auto; margin-bottom: 40px;">
                                                <div class="invoicePreview__sign-position">
                                                    Главный бухгалтер
                                                </div>
                                                <div class="invoicePreview__sign-placeholder">
                                                    (подпись)
                                                    <div class="invoicePreview__sign-sign-block">
                                                        <div class="invoicePreview__sign-sign-wrapper">
                                                            <img src="/images/Подпись.png" class="invoicePreview__sign-sign" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invoicePreview__sign-name">
                                                    <span id="manager">Аксендлер Александр Семенович</span>
                                                </div>
                                            </div>
                                            <div class="invoicePreview__comment" style="padding-top: 0">
                                                <h5 style="font-size: 13px;">ПРИМЕЧАНИЕ:</h5>
                                                <p class="edit" style="font-size: 9px; height: 300px;">
                                                    {!! htmlspecialchars_decode($headers['text']) !!}
                                                </p>
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


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Отправить</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="emailCompany" class="col-sm-2 col-form-label">Кому</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="emailCompany">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emailUser" class="col-sm-2 col-form-label">От:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="emailUser" value="{{\Illuminate\Support\Facades\Auth::user()->login}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="subject" class="col-sm-2 col-form-label">Тема</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="subject">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="textEmail" class="form-label">Текст сообщения</label>
                    <textarea class="form-control" id="textEmail" spellcheck="true" lang="ru" rows="3" >Отправлено из CRM</textarea>
                </div>
                <div class="mb-3" id="nameFileEmail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-click="sentEmail">Отправить</button>
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
    'resources/js/check_total.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
