import {UserService} from "../script.js";

export class Service extends UserService{

    /**
     * Снятие блокировки кнопки редактировать
     */
    static blockButtonEditCompany(){
        const table = document.getElementById('tableCompany');
        let tr = table.querySelectorAll('tr');

        tr.forEach(item=>{
            if(item.classList.contains('active')){
                document.getElementById('butEdit').disabled = false;
            }
        })
    }

    /**
     * Поиск выбранной компании
     * @returns {string}
     */
    static searchActiveCompany(){
        const table = document.getElementById('tableCompany');
        let tr = table.querySelectorAll('tr');
        let id = '';
        tr.forEach(item=>{
            if(item.classList.contains('active')){
                id =  item.dataset.id;
            }
        })

        return id;
    }

    /**
     * Вывод всей информации о компании
     * @param data
     */
    static printBlock(data){
        const block = document.getElementById('delailsBlock');
        data = this.replaceNulls(data);
        block.innerHTML = '';
        block.innerHTML = `
            <div class="row bg-body-tertiary border rounded-3 p-2">
                            <div class="container infoBlock" data-id="${data[0].id}">
                                <div class="row">
                                    <div class="col-12 col-md-6 ps-1">
                                        <div class="row mb-1 mt-2"> <!-- Определяем внутренний блок как строку -->
                                            <div class="col-3 infoTitle">ИНН:</div>
                                            <div class="col-9 infoDis border innInfoBlock" style="min-height: 30px">${data[0].inn}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Адрес Юрид.:</div>
                                            <div class="col-9 infoDis border addressInfoBlock" style="min-height: 43px">${data[0].address}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Контакт:</div>
                                            <div class="col-9 infoDis border contact" style="min-height: 30px">${data[0].name_contact}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Телефон:</div>
                                            <div class="col-9 infoDis border phone" style="min-height: 30px">${data[0].phone_contact}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">E-mail:</div>
                                            <div class="col-9 infoDis border email" style="min-height: 30px">${data[0].email_contact}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Сайт:</div>
                                            <div class="col-9 infoDis border site" style="min-height: 30px">${data[0].sait_company}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Менеджер</div>
                                            <div class="col-9 infoDis border site" style="min-height: 30px">${data[0].name}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 pe-0">
                                        <div class="mb-2 mt-2" style="position: relative">
                                            <label for="exampleFormControlTextarea1" class="form-label">Комментарий</label>
                                            <textarea class="form-control mb-2 commentCompany" id="commentCompany" style="height: 190px; resize: none;" data-input="textarea" >${data[0].info_company}</textarea>
                                            <div class="pleacholderText" id="textInfo" style="width: 100%; height: 25px; color: #5f6062; position: absolute;top: 75%;left: 2%; font-size: 13px">Введено 22 из 255 символов</div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-click="sent">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="row bg-body-tertiary border rounded-3 p-2 mt-2 ">
                            <div class="form-check form-switch mb-3 buttonGroup"><div>
                                    <input class="form-check-input" type="checkbox" data-change="archive">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" style="margin-right: 10px">Архив</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm exelBut" data-bs-toggle="modal" data-bs-target="#exel">Exel
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-click="addCheck">Добавить
                                    </button>
                                </div></div>
                            <div class="col justify-content-center tableCheck ps-0 pe-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="tHeadSortable">
                                    <tr class="">
                                        <th>№ счета</th>
                                        <th>Сумма счета</th>
                                        <th>Статус</th>
                                        <th>Дата создания</th>
                                        <th style="text-align: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-diamond-fill" viewBox="0 0 16 16">
                                                <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L4.047 3.339 8 7.293l3.954-3.954L9.049.435zm3.61 3.611L8.708 8l3.954 3.954 2.904-2.905c.58-.58.58-1.519 0-2.098l-2.904-2.905zm-.706 8.614L8 8.708l-3.954 3.954 2.905 2.904c.58.58 1.519.58 2.098 0l2.905-2.904zm-8.614-.706L7.292 8 3.339 4.046.435 6.951c-.58.58-.58 1.519 0 2.098z"></path>
                                            </svg>
                                        </th>
                                    </tr>

                                    </thead>
                                    <tbody class="ui-sortable">

                                    </tbody>
                                </table></div>
                        </div>
        `;


    }

    /**
     * Замена null в пустую строку для ответа json
     * @param obj
     * @returns {*}
     */
    static replaceNulls(obj) {
        for (const key in obj) {
            if (obj[key] === null) {
                obj[key] = "";
            } else if (typeof obj[key] === "object" && !Array.isArray(obj[key])) {
                this.replaceNulls(obj[key]); // рекурсивный вызов для вложенных объектов
            }
        }
        return obj;
    }

    /**
     * Функция прав администратора
     * @param data
     */
    static admin(data) {
        if (data === true) {
            const block = document.querySelector('.allSaleAdmin');

            let div = document.createElement('div');
            div.classList = "form-check form-switch mb-3 adminPanel";
            div.innerHTML = `
                    <input class="form-check-input checkbox" type="checkbox" id="flexSwitchCheckDefault" data-click="allCompany">
                    <label class="form-check-label" for="flexSwitchCheckDefault" >Показать все</label>
                    <button
                    type="button"
                    class="btn btn-outline-primary btn-sm editButton"
                    id="butEdit"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#staticBackdrop"
                    aria-controls="staticBackdrop"
                    style="float: right;"
                    disabled
                    data-click="editCompany">Редактировать</button>
            `;
            block.prepend(div);
        }
    }

    /**
     * Функция форматирования даты 2024-03-01 в формат 01 марта 2024
     * @param dateString
     * @returns {string}
     */
    static formatDateService(dateString) {
        let months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
        let dateParts = dateString.split("-");
        let year = dateParts[0];
        let month = months[parseInt(dateParts[1]) - 1]; // вычитаем 1, так как массивы в JavaScript начинаются с 0
        let day = dateParts[2];
        return day + " " + month + " " + year;
    }

    /**
     * Цвет прогресс бара
     * @param size
     * @returns {string}
     */
    static colorProgress(size){
        switch(size) {
            case '16.6' :
                return '#0a5cae';
            case '34.2':
                return  'rgb(185, 124, 34)';
            case '50':
                return 'rgb(166, 142, 44)';
            case '67.2':
                return 'rgb(144,166,44)';
            case '86.6':
                return 'rgb(135, 164, 28)';
            default:
                return  'rgb(82,165,27)';
        }
    }

}

export class Client extends Service {

    /**
     * Вывод всех компаний пользователя
     */
    static getClient() {
        this.preLoad();

        fetch('/client/getClient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'value': true,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.querySelector('.allSaleAdmin').innerHTML = `
                    <div class="mb-3 col-12" style="overflow: scroll; height: 90%; max-height: 95vh;">
                                <table class="table table-hover">
                                    <thead class="sticky-top">
                                    <tr>
                                        <th>Компания</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableCompany">
                                    </tbody>
                                </table>
                            </div>
                `;
                this.admin(data.admin);
                this.#printAllCompanyUser(data.company);
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вывод всех компаний пользователя
     * @param data
     */
    static #printAllCompanyUser(data) {
        let table = document.getElementById('tableCompany');
        table.innerHTML = '';
        for (let i = 0; i < data.length; i++) {
            let tr = document.createElement('tr');
            tr.dataset.id = data[i].id;
            let count = '';
            if(data[i].count > 0){
                count = data[i].count;
            }
            tr.innerHTML = `
                <td data-click="active">${data[i].name}<span class="badge text-bg-primary" style="float: right;">${count}</span></td>
            `;
            table.append(tr);
        }

        document.getElementById('delailsBlock').innerHTML = `
                    <div class="container">
                        <div class="row">
                            <div class="col align-middle" style="text-align: center; margin-top: 50%">
                                <i class="bi bi-incognito" style="font-size: 70px; opacity: 0.4;"></i>
                                <p>Выберете компанию</p>
                            </div>
                        </div>
                    </div>
            `;
    }

    /**
     * Вывод информации об активной компании
     * @param elem
     */
    static active(elem) {

        const table = document.getElementById('tableCompany');
        const allTr = table.querySelectorAll('tr');

        allTr.forEach(item => {
            item.classList.remove('active');
        })

        let tr = elem.target.closest('tr');
        tr.classList.add('active');

        this.getActiveCompany(tr.dataset.id);


    }

    /**
     * вывод окна детализации компании
     * @param id
     */
    static getActiveCompany(id) {
        let table = document.querySelector('.adminPanel')
        if(table){
            this.blockButtonEditCompany();
        }

        this.preLoad();

        fetch('/client/getActiveCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            }),
        }).then(response => response.json())
            .then(data => {

                this.deletePreloader(); // Вызов метода родителя
                this.printBlock(data.company);
                this.countTextTextarea('commentCompany', 'textInfo');
                this.printAllCheck(data.check);

            }).catch(error => {

            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вывод всех счетов компании
     * @param data
     */
    static printAllCheck(data) {

        const table = document.querySelector('.ui-sortable');


        for (let i = 0; i < data.length; i++) {
            let border = '';
            if (data[i].status === '100') {
                border = '59px'
            } else {
                border = '50px 0px 0px 50px';
            }
            let tr = document.createElement('tr');
            let dateTime = this.formatDate(data[i].date_check);
            tr.dataset.check = data[i].id;
            tr.dataset.dblclick = 'check';
            tr.classList.add('sale_tr');
            tr.innerHTML = `
                <td data-description="chet" data-click="activeTr">${data[i].number_check}</td>
                <td data-description="result" data-click="activeTr">${this.spaceDigits(data[i].result)} руб</td>

                <td data-description="status" data-click="activeTr">
                    <div id="progress" class="ProgressBar">
                        <div class="row">
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '16.6') ? 'active_progress' : ''}" data-click="progress" data-size="16.6">Новый</span>
                            </div>
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '34.2') ? 'active_progress' : ''}" data-click="progress" data-size="34.2">Отсроска</span>
                            </div>
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '50') ? 'active_progress' : ''}" data-click="progress" data-size="50">Оплачен</span>
                            </div>
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '67.2') ? 'active_progress' : ''}" data-click="progress" data-size="67.2">Отгрузка</span>
                            </div>
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '86.6') ? 'active_progress' : ''}" data-click="progress" data-size="86.6">Закрывающие</span>
                            </div>
                            <div class="col labelProgress">
                                <span class="span_progress ${(data[i].status === '100') ? 'active_progress' : ''}" data-click="progress" data-size="100">Архив</span>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: ${data[i].status}%; background-color: ${this.colorProgress(data[i].status)}; border-radius: ${border};" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </td>

                <td data-description="date" data-click="activeTr">${dateTime['full']}</td>
                <td data-description="date" style="text-align: center;vertical-align: middle;" class="details-check" data-click="activeTr" data-click="activeTr">
                    <i class="bi bi-search" data-click="detailsCheck"></i>
                </td>
            `;

            table.append(tr);
        }

    }

    /**
     * Удаление блока информации о счета
     */
    static deleteDetailsCheck() {
        let elem = document.querySelectorAll('.detailCheck');
        elem.forEach(item => {
            if (item) {
                item.classList.add('fade-out');
                setTimeout(() => {
                    item.remove();
                }, 800);
            }
        })
    }

    /**
     * Вывод блока информации о счета
     * @param elem
     */
    static addBlockDetails(elem) {
        const detailsBlock = document.createElement('tr');
        detailsBlock.classList.add('detailCheck');
        const id = elem.dataset.check;
        this.preLoad();

        fetch('/client/getDetailsCheck', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                let info = '';
                for (let i = 0; i < data.length; i++) {
                    info += `
            <tr>
                   <td style="text-align: left; font-weight: 399;">${i + 1}</td>
                   <td style="text-align: left; font-weight: 399;">${data[i].name}</td>
                   <td style="text-align: right; font-weight: 399;">${data[i].unit}</td>
                   <td style="text-align: right; font-weight: 399;">${this.spaceDigits(data[i].count)}</td>
                   <td style="text-align: right; font-weight: 399;">${this.spaceDigits(data[i].price) + ' руб'}</td>
                   <td style="text-align: right; font-weight: 399;">${this.spaceDigits(data[i].result) + ' руб'}</td>
            </tr>
        `;
                }
                detailsBlock.innerHTML = `
                       <td colspan="5" style="text-align: start;">
                            <table class="table table-hover">
                               <thead>
                                 <tr>
                                   <th style="width: 4%;font-weight: 400;">№ </th>
                                   <th style="width: 50%;font-weight: 400;">Товар или услуга </th>
                                   <th style="text-align: right; width: 3%; font-weight: 400;">Ед.из</th>
                                   <th style="text-align: right; width: 12%; font-weight: 400;">Кол-во</th>
                                   <th style="text-align: right; width: 12%; font-weight: 400;">Стоимость</th>
                                   <th style="text-align: right; width: 12%; font-weight: 400;">Цена </th>
                                 </tr>
                               </thead>
                           <tbody>
                        ${info}
                           </tbody>
                        </table>
                        </td>
               `;
                elem.after(detailsBlock);
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });


    }

    /**
     * Детализация счета
     */
    static detailsCheck(elem) {

        const tr = elem.target.closest('tr');
        const nextElem = tr.nextElementSibling; // Получаем только следующий элемент <tr>

        if (!nextElem || !nextElem.classList.contains('detailCheck')) { // Проверяем, есть ли следующий элемент и содержит ли он класс
            this.deleteDetailsCheck(); // Вызываем метод удаления деталей проверки
            this.addBlockDetails(tr);
            const tegI = document.querySelectorAll('.bi-search');
            tegI.forEach(item => {
                item.classList.remove('active-search');
            })
            elem.target.classList.add('active-search');
        } else {
            const tegI = document.querySelectorAll('.bi-search');
            tegI.forEach(item => {
                item.classList.remove('active-search');
            })
            this.deleteDetailsCheck();
        }

    }

    /**
     * Создать новый счет
     */
    static addCheck() {
        let elem = {
            'name' : document.querySelector('.contact'),
            'phone' : document.querySelector('.phone'),
            'email' : document.querySelector('.email'),
        }

        let error = false;

        for (const elemElement in elem) {
            if(elem[elemElement].textContent.trim() === '') {
                elem[elemElement].classList.add('error');
                error = true;
            } else {
                elem[elemElement].style.border = '';
            }
        }

        if(error === true){
            return false;
        }

        let id = this.searchActiveCompany();
        window.location.href = `/check?id=${id}`;
    }

    /**
     * Смена статуса счета
     * @param elem
     */
    static progress(elem) {
        const size = elem.target.dataset.size;
        const parent = elem.target.closest('#progress');
        const progressBar = parent.querySelector('.progress-bar');
        const span = parent.querySelectorAll('span');
        const tr = elem.target.closest('tr');

        const check = {
            'id': tr.dataset.check,
            'size': size,
        }

        span.forEach(item => {
            item.classList.remove('active_progress');
        })

        elem.target.classList.add('active_progress');
        let inputChecked = document.querySelector('[data-change="archive"]');

        switch (size) {
            case '16.6':
                progressBar.style.width = size + '%';
                progressBar.style.backgroundColor = '#0a5cae';
                this.setStatusProgress(check);
                this.countCheck(inputChecked, elem);
                break;
            case '34.2':
                progressBar.style.width = size + '%';
                progressBar.style.backgroundColor = 'rgb(185, 124, 34)';
                this.modalShow('sentMessage');
                document.getElementById('formMassage').dataset.id = tr.dataset.check;
                document.getElementById('formMassage').dataset.size = size;
                this.countCheck(inputChecked, elem);
                break;
            case '50':
                progressBar.style.width = size + '%';
                progressBar.style.backgroundColor = 'rgb(166, 142, 44)';
                this.setStatusProgress(check);
                this.countCheck(inputChecked, elem);
                break;
            case '67.2':
                progressBar.style.width = size + '%';
                progressBar.style.backgroundColor = 'rgb(144,166,44)';
                this.setStatusProgress(check);
                this.countCheck(inputChecked, elem);
                break;
            case '86.6':
                progressBar.style.width = size + '%';
                progressBar.style.backgroundColor = 'rgb(135, 164, 28)';
                this.setStatusProgress(check);
                this.countCheck(inputChecked, elem);
                break;
            default:
                this.setStatusProgress(check)
                progressBar.style.width = size + '%'
                progressBar.style.backgroundColor = 'rgb(82,165,27)';
                progressBar.style.borderRadius = '50px 0px 0px 50px'
                setTimeout(() => {
                    elem.target.closest('tr').remove();
                    if (inputChecked.checked === false) {
                        let trCompany = document.querySelector('tr.active');
                        let num = parseInt(trCompany.querySelector('span.badge').innerHTML);
                        trCompany.querySelector('span.badge').innerHTML = num - 1;
                        if((num-1) <= 0){
                            trCompany.querySelector('span.badge').style.display = 'none';
                        }
                    }
                    this.sort();
                }, 800);
                break;
        }
    }

    /**
     * Подсчет количества счетов
     * @param inputChecked
     * @param elem
     */
    static  countCheck (inputChecked, elem) {
        if (inputChecked.checked === true) {
            setTimeout(() => {
                elem.target.closest('tr').remove();
                let trCompany = document.querySelector('tr.active');
                    trCompany.querySelector('span.badge').style.display = 'block';
                let num = parseInt(trCompany.querySelector('span.badge').innerHTML);
                trCompany.querySelector('span.badge').innerHTML = num + 1;
                this.sort();
            }, 800);
        }

    }

    /**
     * Сортировка компаний
     */
    static sort(){
        // Получаем все строки таблицы
        const table = document.getElementById('tableCompany');
        const rows = Array.from(table.rows);

        // Сортируем строки по значению внутри span
        const sortedRows = rows.sort((a, b) => {
            const aValue = parseInt(a.querySelector('.badge').textContent) || 0;
            const bValue = parseInt(b.querySelector('.badge').textContent) || 0;

            return bValue - aValue; // Сортировка по возрастанию
        });

        // Удаляем все строки из таблицы
        while (table.firstChild) {
            table.removeChild(table.firstChild);
        }

        // Добавляем отсортированные строки обратно в таблицу
        sortedRows.forEach(row => {
            table.appendChild(row);
        });
    }

    /**
     * Установка статуса счета
     * @param check
     */
    static setStatusProgress(check) {
        this.preLoad();

        fetch('/client/progressCheck', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(check),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Получение архива счетов
     * @param id
     */
    static checkClose(id) {
        this.preLoad();

        fetch('/client/checkClose', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                const table = document.querySelector('.ui-sortable');
                const tr = table.querySelectorAll('tr');
                tr.forEach(item => {
                    item.remove();
                })
                this.printAllCheck(data);
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Получение архива счетов
     * @param id
     */
    static checkNoClose(id) {
        this.preLoad();

        fetch('/client/checkNoClose', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                const table = document.querySelector('.ui-sortable');
                const tr = table.querySelectorAll('tr');
                tr.forEach(item => {
                    item.remove();
                })
                this.printAllCheck(data);
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Отправка сообщения в телеграмм
     */
    static sentMessage() {
        const id = document.getElementById('formMassage').dataset.id;
        const size = document.getElementById('formMassage').dataset.size;
        const form = {
            'sumProvider': document.getElementById('sumProvider').value.trim(),
            'sumLogist': document.getElementById('sumLogist').value.trim(),
            'countDayLogist': document.getElementById('countDayLogist').value.trim(),
            'countDayPay': document.getElementById('countDayPay').value.trim(),
            'usloviya': document.getElementById('usloviya').value.trim(),
            'id': id,
            'size': size
        }
        this.preLoad();

        fetch('/client/sentMessage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(form),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                let form = document.getElementById('formMassage');
                form.querySelectorAll('input').forEach(item => {
                    item.value = '';
                })
                this.modalHide('sentMessage');
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Выбор селект для загрузки из файла
     * @param elem
     */
    static optionData(elem) {
        const selects = document.querySelectorAll('.exelSelect');
        const selectedValue = elem.target.value;
        selects.forEach(item => {
            if (item.value === selectedValue && item !== elem.target) {
                item.value = '';
            }
        });
    }

    /**
     * Загрузка файла из exel
     * @returns {boolean}
     */
    static sentFileExel() {

        let error = false; // Используем флаг вместо числа
        let file = '';
        let thead = document.getElementById('theadExel');
        let table = document.getElementById('exelBody');
        table.innerHTML = '';
        thead.innerHTML = '';


        if (document.getElementById('formFile')) {

            // Получаем элемент input с типом file
            let fileInput = document.getElementById('formFile');
            file = fileInput.files[0];

            if (fileInput.files[0] === undefined) {
                document.getElementById('formFile').style.border = '1px solid red';
            } else {
                document.getElementById('formFile').style.border = '1px solid green';
            }

            // Проверяем, был ли выбран файл
            if (file) {
                let maxFileSize = 50 * 1024 * 1024; // Максимальный размер файла: 10 МБ

                // Проверяем размер файла
                if (file.size > maxFileSize) {
                    document.querySelector('.errorFileContract').innerHTML = "Файл слишком большой. Максимальный размер: " + (maxFileSize / (1024 * 1024)) + " МБ."
                    document.getElementById('formFile').style.border = '1px solid red';
                    error = true; // Устанавливаем флаг в true при неудачной проверке
                }

                const mimeType = file.type;
                if (mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                    mimeType === 'application/vnd.ms-excel') {

                } else {
                    document.querySelector('.errorFileContract').innerHTML = 'Фаил не является .xlsx';
                    document.getElementById('formFile').style.border = '1px solid red';
                    error = true;
                }

            } else {
                document.getElementById('formFile').style.border = '1px solid red';
                error = true; // Устанавливаем флаг в true при отсутствии файла
            }
        }

        if (error) { // Проверяем флаг
            return false;
        }


        this.preLoad();

        let formData = new FormData();
        formData.append('file', file);


        fetch('/client/sentFile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        }).then(response => response.json())
            .then(data => {

                this.deletePreloader(); // Вызов метода родителя

                let trForThead = document.createElement('tr');
                let th = '';
                for (let j = 0; j < data[0].length; j++) {
                    th += `
                            <th style="padding: 1px">
                                <select class="exelSelect" data-change="optionData">
                                    <option value=""></option>
                                    <option value="name">Наименование</option>
                                    <option value="unit">Ед.из</option>
                                    <option value="price">Цена</option>
                                    <option value="count">Количество</option>
                                </select>
                            </th>
                        `;
                }

                trForThead.innerHTML = th;
                thead.append(trForThead);


                for (let i = 0; i < data.length; i++) {
                    let tr = document.createElement('tr');
                    let td = '';
                    for (let j = 0; j < data[i].length; j++) {
                        td += `<td>${(data[i][j] !== null) ? data[i][j] : ''}</td>`;
                    }
                    tr.innerHTML = td;
                    table.append(tr);
                }

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Добавление счета из таблицы exel
     * @returns {boolean}
     */
    static addCheckFile() {
        const tbody = document.getElementById('exelBody');
        const selectAll = document.querySelectorAll('select');
        const selectedIndices = [];

        // Находим индексы выбранных элементов
        selectAll.forEach((selectElement, index) => {
            if (selectElement.value !== "") { // Проверяем, что значение не пустое
                selectedIndices.push({index, key: selectElement.value}); // Сохраняем объект с индексом и значением select
            }
        });

        //проверяем все ли select заполнены
        if (selectedIndices.length < 4) {
            for (let i = 0; i < selectAll.length; i++) {
                selectAll[i].style.border = '1px solid red';
            }
            return false;
        }

        const position = []; // Объявляем массив для позиций
        const tr = tbody.querySelectorAll('tr'); // Получаем все строки таблицы

        // Обходим каждую строку таблицы
        tr.forEach(item => {
            const rowObj = {}; // Объект для значений текущей строки
            selectedIndices.forEach(({index, key}) => {
                // Получаем значение из children по каждому индексу и добавляем в объект
                rowObj[key] = item.children[index].textContent; // Или используйте .value, если это input
            });
            position.push(rowObj); // Добавляем объект текущей строки в общий массив
        });

        const result = {
            position: position,
            head: this.searchActiveCompany() // Добавляем результат вызова searchActiveCompany
        };

        this.preLoad();
        fetch('/client/addCheckExel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(result)
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.getElementById('theadExel').innerHTML = '';
                document.getElementById('exelBody').innerHTML = '';
                document.getElementById('formFile').value = '';
                this.modalHide('exel');
                let id = this.searchActiveCompany();
                this.getActiveCompany(id);
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Добавление комментария компании
     */
    static sent() {
        const textarea = document.querySelector('textarea.commentCompany').value;

        this.preLoad();
        fetch('/client/addComment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'text': textarea.trim(),
                'id': this.searchActiveCompany(),
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя


            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вывод всех компаний
     * @param elem
     */
    static allCompany(elem) {
        this.preLoad();

        fetch('/client/allCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'company': 'all',
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                this.#printAllCompanyUser(data.company);

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вывод данных о компании в окно редактирования
     */
    static editCompany() {
        this.preLoad();

        fetch('/client/editCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': this.searchActiveCompany(),
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                document.getElementById('nameCompanyEdit').value = data['company'].name;
                document.getElementById('innEditCompany').value = data['company'].inn;
                document.getElementById('urAddressEditCompany').value = data['company'].address;
                document.getElementById('contactEditCompany').value = data['company'].name_contact;
                document.getElementById('phoneEditCompany').value = data['company'].phone_contact;
                document.getElementById('emailEditCompany').value = data['company'].email_contact;
                document.getElementById('siteEditCompany').value = data['company'].sait_company;
                document.getElementById('selectUserCompany').innerHTML = '';
                for (let i = 0; i < data['users'].length; i++) {
                    let options = document.createElement('option');
                    options.value = data['users'][i].id;
                    options.textContent = data['users'][i].name;
                    document.getElementById('selectUserCompany').append(options);
                }

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Сохранение обновленных данных
     */
    static saveEditCompany() {

        const form = {
            'contact': document.getElementById('contactEditCompany').value,
            'phone': document.getElementById('phoneEditCompany').value,
            'email': document.getElementById('emailEditCompany').value,
            'site': document.getElementById('siteEditCompany').value,
            'users': document.getElementById('selectUserCompany').value,
            'id_company': this.searchActiveCompany(),
        }

        this.preLoad();

        fetch('/client/saveEditCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(form)
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                const id = this.searchActiveCompany();
                this.getActiveCompany(id);
                this.offcanvasHide('staticBackdrop');

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.offcanvasHide('staticBackdrop');
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Поиск по инн
     */
    static searchForInn() {
        let url = "http://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
        let token = "5ab8480580c1750bfa46f56c16f4c896a6673aa0";
        const input = document.getElementById('searchInn').value.trim();

        let options = {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Token " + token
            },
            body: JSON.stringify({query: input})
        }

        fetch(url, options)
            .then(response => response.json())
            .then(result => {
                document.getElementById('searchInn').value = '';
                document.getElementById('addNameCompany').value = result['suggestions'][0].value
                document.getElementById('addInnCompany').value = result['suggestions'][0]['data'].inn;
                document.getElementById('addKppCompany').value = result['suggestions'][0]['data'].kpp;
                document.getElementById('addUrAddressCompany').value = result['suggestions'][0]['data']['address'].value;
            })
            .catch(error => console.log("error", error));
    }

    /**
     * Вывод списка пользователей для добавления компании
     */
    static addCompanyClient() {

        this.preLoad();

        fetch('/client/allUsers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                let datalist = document.getElementById('addManager');
                for (let i = 0; i < data.length; i++) {
                    let option = document.createElement('option');
                    option.value = data[i].id;
                    option.textContent = data[i].name;
                    datalist.append(option);
                }
                this.modalShow('addCompanyClient');
                this.countTextTextarea('textAreaInput', 'countText');
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalHide('addCompanyClient');
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Добавление клиента
     * @returns {boolean}
     */
    static setClient(){
        const inputs = {
            'name' : document.getElementById('addNameCompany'),
            'inn' : document.getElementById('addInnCompany'),
            'kpp' : document.getElementById('addKppCompany'),
            'address' : document.getElementById('addUrAddressCompany'),
            'contact' : document.getElementById('addUserCompany'),
            'phone' : document.getElementById('addUserPhoneCompany'),
            'email' : document.getElementById('addUserEmailCompany'),
            'user' : document.getElementById('addManager'),
            'info' : document.getElementById('textAreaInput'),
        }
        const data = {};

        for (let inputsKey in inputs) {
            if(inputs[inputsKey].value.trim() === ''){
                inputs[inputsKey].style.border = '1px solid red';
                return false;
            }else{
                inputs[inputsKey].style.border = '';
                data[inputsKey] = inputs[inputsKey].value.trim();
            }
        }

        this.preLoad();

        fetch('/client/addCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body : JSON.stringify(data)
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.getClient();
                this.modalHide('addCompanyClient');
                for (let inputsKey in inputs) {
                    inputs[inputsKey].value = '';
                    if(inputsKey === 'user'){
                        inputs[inputsKey].innerHTML = '';
                    }
                }
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Поиск по компаниям
     * @returns {boolean}
     */
    static search(){
        const search = document.getElementById('search');
              search.value = search.value.trim();

        if(search.value.trim() === ''){
            this.getClient();
            return false;
        }

        this.preLoad();

        fetch('/client/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body : JSON.stringify({
                'text' : search.value,
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                this.#printAllCompanyUser(data.company);

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }
}

