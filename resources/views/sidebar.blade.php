<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary sadeBars" style="width: 15%;">
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
                <strong class="align-middle" style="font-size: 13px; color: #f0f1f2; text-overflow: ellipsis; overflow: hidden;">{{ Auth::user()->name }}</strong>
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

<div class="sadeBar">

    <div  class="container">
        <div class="row">
            <div class="col-2">
                <i class="bi bi-justify" id="filterIcon"></i>
            </div>
            <div class="col ps-0 block-name-company">
                <span class="name-company">{{ env('APP_NAME_COMPANY', 'CRM') }}</span>
            </div>
        </div>
    </div>

    <div class="dropdown-content" id="dropdownContent">
        <ul class="list-unstyled ps-0"><li>
                <a href="/api/main" class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed main_link">
                    <i class="bi bi-lamp"></i>&nbsp; Главная
                </a>
                <i class="bi bi-pencil editMenu"></i>
            </li><li>
                <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#информация-collapse" aria-expanded="false">
                    <i class="bi bi-book"></i>&nbsp; Информация
                </button>
                <div class="collapse" id="информация-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="editMenuLi"><a href="/provider" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Поставщики</a></li><li class="editMenuLi"><a href="/logistic" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Экспедиторы</a></li><li class="editMenuLi"><a href="/manager" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Менеджеры поставщиков</a></li>
                    </ul>
                </div>
            </li><li>
                <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#документы-collapse" aria-expanded="false">
                    <i class="bi bi-box-seam"></i>&nbsp; Документы
                </button>
                <div class="collapse" id="документы-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="editMenuLi"><a href="/fileManager" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Файлы</a></li>
                    </ul>
                </div>
            </li><li>
                <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#продажи-collapse" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"></path>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"></path>
                    </svg>&nbsp; Продажи
                </button>
                <div class="collapse" id="продажи-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="editMenuLi"><a href="my_sale.php" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Продажи</a></li><li class="editMenuLi"><a href="/my_company" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Клиенты</a></li><li class="editMenuLi"><a href="/company" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Компании Админ</a></li><li class="editMenuLi"><a href="/calls" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Холодные звонки</a></li>
                    </ul>
                </div>
            </li></ul>
        <div class="mb-1">
            <div class="dropdown border-top">
                <a href="#" class="d-flex align-items-start justify-content-start p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->link_ava }}" alt="mdo" width="24" height="24" class="rounded-circle me-2">
                    <strong class="align-middle" style="font-size: 13px; color: #f0f1f2; text-overflow: ellipsis; overflow: hidden;">{{ Auth::user()->name }}</strong>
                </a>
                <ul class="dropdown-menu text-small shadow userMenu" aria-labelledby="dropdownUser3">
                    <li><a class="dropdown-item" href="/profile">Профиль</a></li>
                    <li><a class="dropdown-item" href="/setting">Настройки</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item exitUser" href="#">Выход</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
