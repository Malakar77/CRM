<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/sidebars.css', 'resources/css/attorney.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
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
                    <div class="nav-icon-container">
                        <div id="menu" class="nav-icon-block" >
                            <div class="nav-icon">
                                <i class="bi bi-printer" data-action="print"></i>
                            </div>
                            <div class="nav-icon">
                                <i class="bi bi-cloud-download" data-action="download"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row">
            <div class="container " >
                <div class="d-grid gap-3" style="width: 69%;
  margin: 0 auto;
  background-color: #fff;
  padding: 25px;
  height: 90vh;
  overflow: scroll;
  color: #0f0f0f">
                    <div class="container_blank">
                        <div class="row">
                            <div class="containerHead">
                                <div class="rowHead">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Номер доверен.</th>
                                            <th>Дата выдачи</th>
                                            <th>Срок действия</th>
                                            <th>Должность и фамилия лица, которому выдана доверенность</th>
                                            <th>Расписка в получении доверенности</th>
                                            <th>Поставщик</th>
                                            <th>Номер и дата наряда(заменяющего наряда док.) или извещения</th>
                                            <th>Номер, дата документа, подтверждающего выполнение поручения</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbodyHead">
                                            <tr>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>5</td>
                                                <td>6</td>
                                                <td>7</td>
                                                <td>8</td>
                                            </tr>
                                            <tr class="trHead">
                                                <td class="a1"></td>
                                                <td class="a2"></td>
                                                <td class="a3"></td>
                                                <td class="a4"></td>
                                                <td></td>
                                                <td class="a6"></td>
                                                <td></td>
                                                <td class="a8"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="container">
                                        <div class="row">
                                            <div class="line"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="containerInfo">
                                <div class="rowInfo">
                                    <span class="oneInfo">Типовая межотраслевая форма № М-2</span>
                                    <span class="twoInfo">Утверждена постановлением</span>
                                    <span class="treeInfo">Госкомстата России от 30.10.97 г. № 71а</span>
                                </div>
                            </div>
                            <div class="containerCode">
                                <div class="rowCode">
                                    <div class="colCodeOne">
                                        <span>Коды</span>
                                    </div>
                                    <div class="colCodeTwo">
                                        <span>Форма по ОКУД</span>
                                        <span>315001</span>
                                    </div>
                                    <div class="colCodeTree">
                                        <span>Организация</span>
                                        <span id="companyName"></span> {{--ООО АК Сплав--}}
                                        <span>по ОКПО</span>
                                        <span>71354842</span>
                                    </div>
                                </div>
                            </div>
                            <div class="containerNum">
                                <div class="rowNum">
                                    <div class="colNum">
                                        <span>Доверенность №</span>
                                        <span id="numberDov"></span>{{--ДДМ123--}}
                                    </div>
                                </div>
                            </div>
                            <div class="containerDate">
                                <div class="rowDate">
                                    <div class="colDate">
                                        <span>Дата выдачи</span>
                                        <span id="date_ot_day"></span>{{--12--}}
                                        <span id="date_ot_month"></span>{{--октября--}}
                                        <span id="date_ot_yeas"></span>{{--2024--}}
                                        <span>г.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_date">
                                <div class="row_date">
                                    <div class="col_date">
                                        <span>Доверенность действительна по</span>
                                        <span id="date_do_day"></span>{{--12--}}
                                        <span id="date_do_month"></span>{{--октября--}}
                                        <span id="date_do_yeas"></span>{{--2024--}}
                                        <span>г.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_company">
                                <div class="row_company">
                                    <div class="col_company">
                                        <span id="company_name"></span>{{--ООО "АК СПЛАВ", ИНН: 7751232801, КПП: 775101001, город Москва, ш. Киевское, км 22-Й, двлд. 4 стр. 2, офис 405г--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_pay">
                                <div class="row_pay">
                                    <div class="col_pay">
                                        <span id="companyDB"></span>{{--ООО "АК СПЛАВ", ИНН: 7751232801, КПП: 775101001, город Москва, ш. Киевское, км 22-Й, двлд. 4 стр. 2, офис 405г--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_check">
                                <div class="row_check">
                                    <div class="col_check">
                                        <span>Счет №</span>
                                        <span id="check"></span>{{--40702810802860015593, в банке АО “АЛЬФА-БАНК”, БИК 044525593, к/с 30101810200000000593--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_user">
                                <div class="row_user">
                                    <div class="col_user">
                                        <span>Доверенность выдана</span>
                                        <span id="logistName"></span>{{--Иванов Иван Иванович--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_passport">
                                <div class="row_passport">
                                    <div class="col_passport">
                                        <span id="document"></span>{{--Документ (паспорт, в/у и т.д.)--}}
                                        <span id="series"></span>{{--5515--}}
                                        <span>№</span>
                                        <span id="number"></span>{{--456456--}}
                                    </div>
                                </div>
                            </div>
                            <div class="container_iss">
                                <div class="row_iss">
                                    <div class="col_iss">
                                        <span>Кем выдан</span>
                                        <span id="issued"></span>{{--ОУФМС РОССИИ ПО ПРИМОРСКОМУ КРАЮ В ПЕРВОМАЙСКОМ РАЙОНЕ ГОР. ВЛАДИВОСТОК--}}
                                    </div>
                                </div>
                            </div>
                            <div class="container_iss_date">
                                <div class="row_iss_date">
                                    <div class="col_iss_date">
                                        <span>Дата выдачи</span>
                                        <span id="date_issued_day"></span>{{--12--}}
                                        <span id="date_issued_month"></span>{{--октября--}}
                                        <span id="date_issued_yeas"></span>{{--2024--}}
                                        <span>г.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_provider">
                                <div class="row_provider">
                                    <div class="col_provider">
                                        <span>На получение от</span>
                                        <span id="companyProvider"></span>{{--ООО"КОНТИНЕНТАЛЬ"--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_tmc">
                                <div class="row_tmc">
                                    <div class="col_tmc">
                                        <span>материальных ценностей по</span>
                                        <span id="infoBlock"></span>{{--ТМЦ по счету № МСК-84993/01 от 10 сентября 2024 г.--}}
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_table">
                                <div class="row_table">
                                    <div class="col_table">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th style="width: 100px">Номер по порядку</th>
                                                <th>Материальные ценности</th>
                                                <th style="width: 100px">Единица измерения</th>
                                                <th>Количество (прописью)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="container_signature_user">
                                <div class="row_signature_user">
                                    <div class="col_signature_user">
                                        <span>Подпись лица, получившего доверенность</span>
                                        <span></span>
                                        <span>удостоверяем</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_signature_company">
                                <div class="row_signature_company">
                                    <div class="col_signature_company">
                                        <span>Руководитель</span>
                                        <span></span>
                                        <span></span>
                                        <span>Аксендлер А. С.</span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_stamp">
                                <div class="row_stamp">
                                    <div class="col_stamp">
                                        <span>М.П.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container_signature_company">
                                <div class="row_signature_company">
                                    <div class="col_signature_company">
                                        <span>Главный бухгалтер</span>
                                        <span></span>
                                        <span></span>
                                        <span>Аксендлер А. С.</span>
                                        <span></span>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="name">Доп Информация</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container text-left">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Контакты</h5>
                                <p id="number">Грачев Игорь</p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5>Транспорт и услуги</h5>
                                <p id="transportDetails">Газель 1,5 тонны борт 6,0х2,08 грузы до 9 метров <br>Хёндай 5 тонник борт 4,85х2,2 грузы до 6 метров <br>Газель 1,5 тонны борт 4,2х2,0 грузы до 6 метров 3 машины, есть проходная в центр Москвы.<br>Газель 1,5 тонны борт 3,1х1,97 грузы до 6 метров 1 машина.<br>ВИС 850 кг борт 1,6х1,8 проходная в центр Москвы, 2 машины.<br>Тойота легковой универсал проходная в центр Москвы.<br><br>АДРЕС СКЛАДА И ОФИСА: МОСКВА УЛ. 6-Я РАДИАЛЬНАЯ 20 Стр.5 </p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5>Доп Информация</h5>
                                <p id="dopInfoDetails">1) Оплата по счету <br>2) ИП +20%<br>3)Обязательно нужно заполнить задание. <br>https://mp100.ru</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
    </div>
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

<!--Конец модельное окно ошибки-->

@vite([
    'resources/js/script.js',
    'resources/js/sidebars.js',
    'resources/js/menu.js',
    'resources/js/userMenu.js',
    'resources/js/color-modes.js',
    'resources/js/Attorney.js',
    'resources/js/timeReload.js',
    'resources/js/time.js',
        ])
</body>
</html>
