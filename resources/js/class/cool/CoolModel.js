import {UserService} from "../../script.js";
import {Service} from "../mainModel.js";

export class CoolModel extends UserService{


    static addTask ()
    {
        const task = Service.validateAddForm();

        if (!task) {
            // Если валидация не прошла, можно показать сообщение об ошибке
            console.log('Ошибка: форма заполнена некорректно.');
            return false;
        }

        task.id_company = document.getElementById('todoModel').dataset.id;

        this.preLoad();

        fetch('/main/addTodo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(task),
        })
            .then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Удаляем прелоадер
                this.addTodo(data.id, data);
                this.modalHide('todoModel');
            })
            .catch(error => {
                this.deletePreloader(); // Удаляем прелоадер
                this.modalShow('error'); // Показываем сообщение об ошибке
            });

    }


    /**
     * Поиск по компаниям
     */
    static search(){
        const input = document.getElementById('search');
        input.value = input.value.trim();
        this.preLoad();

        fetch('cool/getSearch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'value': input.value.trim(),
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                document.querySelector('.result-blocks').innerHTML = `
                    <div class="container">
                        <div class="row" >
                            <div class="col align-middle" style="text-align: center; margin-top: 50%">
                                <i class="bi bi-incognito" style="font-size: 70px; opacity: 0.4;"></i>
                                <p>Выберете компанию</p>
                            </div>
                        </div>
                    </div>
                `;

                document.getElementById('tableCompany').innerHTML = '';
                this.#printAll(data);

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }


    /**
     * Вывод всех активных заданий
     * @param id
     */
    static getTodo(id){
        this.preLoad();

        fetch('cool/getTodo', {
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
                this.printActiveTodo(data);

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вспомогательный метод вывода всех активных заданий
     * @param data
     */
    static printActiveTodo(data){
        let block = document.getElementById('todoList');
        for(let i = 0; i<data.length; i++){
            let todo = document.createElement('li');
            todo.classList = "list-group-item tool-active";
            todo.style.borderLeft = '6px solid ' +data[i].important;
            todo.dataset.id = data[i].id;
            todo.innerHTML=`
                        <div class="row">
                            <div class="col-6 text_todo" style=" font-size: 12px">
                                <span>${data[i].title}</span>
                            </div>
                            <div class="col-5" style="text-align: end; font-size: 12px" >
                                <span style="margin-right: 5px">${this.#Time(data[i].start)}</span>
                            </div>
                            <div class="col-1" style="text-align: end; font-size: 12px" data-action="deleteTodo">
                                <i class="bi bi-trash" data-action="deleteTodo"></i>
                            </div>
                        </div>
                    `;
            block.prepend(todo);
        }
    }

    /**
     * Вывод задания при добавлении
     * @param id
     * @param data
     */
    static addTodo(id, data){
        let block = document.getElementById('todoList');
        let todo = document.createElement('li');
        todo.classList = "list-group-item tool-active";
            todo.dataset.id = id;
        todo.style.borderLeft = '6px solid ' +data.color;
        todo.innerHTML=`
                        <div class="row">
                            <div class="col-6 text_todo" style=" font-size: 12px">
                                <span>${data.title}</span>
                            </div>
                            <div class="col-5" style="text-align: end; font-size: 12px" >
                                <span style="margin-right: 5px">${this.#Time(data.start)}</span>
                            </div>
                            <div class="col-1" style="text-align: end; font-size: 12px" data-action="deleteTodo">
                                <i class="bi bi-trash" data-action="deleteTodo"></i>
                            </div>
                        </div>
                    `;
        block.prepend(todo);

        const table = document.getElementById('tableCompany');
        const rows = Array.from(table.querySelectorAll('tr'));

        rows.forEach(row => {
            const badge = row.querySelector('span.count_todo');

            // Проверяем, является ли строка активной и увеличиваем счетчик
            if (row.classList.contains('activeCompany')) {
                let count = parseInt(badge.textContent) || 0;
                badge.textContent = count + 1;
            }
        });

        // Сортируем строки по значениям в span.badge
        rows.sort((a, b) => {
            const countA = parseInt(a.querySelector('span.count_todo').textContent) || 0;
            const countB = parseInt(b.querySelector('span.count_todo').textContent) || 0;

            // Сортируем по убыванию
            return countB - countA;
        });

        // Очищаем и перезаписываем tbody
        table.innerHTML = '';
        rows.forEach(row => table.appendChild(row));
    }

    /**
     * Формат времени
     * @param inputDateTime
     * @returns {string}
     */
    static #Time(inputDateTime) {
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false };
        const date = new Date(inputDateTime); // Преобразуем строку в объект Date
        const formattedDate = date.toLocaleString('ru-RU', options); // Форматируем дату в соответствии с русскими стандартами

        // Заменяем запятую на "г" и добавляем "г" после года
        return formattedDate.replace(',', 'г').replace(' ', ' ');
    }

    /**
     * Удаление активного задания
     * @param elem
     */
    static deleteTodo(elem){
        let li = elem.target.closest('li');

        fetch('/main/deleteTodo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': li.dataset.id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                li.remove();
                this.#printLog('Удалено задание: ' + li.querySelector('.text_todo').innerText);
                this.sort();
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Сортировка при удалении активного задания
     */
    static sort(){
        const table = document.getElementById('tableCompany');
        const rows = table.querySelectorAll('tr');
        rows.forEach(item=>{
            if(item.classList.contains('activeCompany')){
                let count = item.querySelector('span.count_todo').innerHTML;
                if(parseInt(count) - 1 === 0){
                    item.querySelector('span.count_todo').innerHTML = '';
                    // Получаем tbody и все строки tr
                    const tableCompany = document.getElementById('tableCompany');
                    const rows = Array.from(tableCompany.querySelectorAll('tr'));

                    // Сортируем строки на основе значения внутри <span> в каждой строке
                    rows.sort((a, b) => {
                        const countA = parseInt(a.querySelector('span.count_todo').textContent) || 0;
                        const countB = parseInt(b.querySelector('span.count_todo').textContent) || 0;

                        // Сортируем по убыванию
                        return countB - countA;
                    });

                    // Очищаем tbody и добавляем отсортированные строки
                    tableCompany.innerHTML = '';
                    rows.forEach(row => tableCompany.appendChild(row));

                }else{
                    item.querySelector('span').innerHTML = parseInt(count) - 1;
                }
            }
        })
    }

    /**
     * Метод отправки коммерческого предложения
     */
    static validEmail(){
        let email = document.getElementById('emailCompany');
        let emailUser = document.getElementById('emailUser');
        let subject = document.getElementById('subject');
        let textEmail = document.getElementById('textEmail');
        let fileInput = document.getElementById('fileInput');
        let block = document.getElementById('formEmail');
        let error = true;

        if(email.value.trim() === ''){
            email.classList.add('error');
            error = false;
        }

        if(emailUser.value.trim() === ''){
            emailUser.classList.add('error');
            error = false;
        }

        if(subject.value.trim() === ''){
            subject.classList.add('error');
            error = false;
        }


        if(error !== false){
            email.classList.remove('error');
            emailUser.classList.remove('error');
            subject.classList.remove('error');

            // Создаем объект FormData
            const formData = new FormData();


            // Добавляем данные
            formData.append('id', this.searchActiveCompany());
            formData.append('email', email.value);
            formData.append('emailUser', emailUser.value);
            formData.append('subject', subject.value);
            formData.append('text', textEmail.value);

            // Добавляем файл
            formData.append('file', fileInput.files[0]);
            formData.append('fileOffer', block.dataset.offer);
            formData.append('fileCard', block.dataset.card);

            this.preLoad();

            fetch('cool/sentOffer', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData,
            }).then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData; // Прокидываем ошибку
                    });
                }
                return response.json();
            })
                .then(data => {
                    this.deletePreloader(); // Вызов метода родителя
                    this.modalHide('sentMassage');
                    this.#printLog('Отправлено коммерческое предложение')
                }).catch(error => {
                this.deletePreloader();


                if(error.errors.email){
                    email.classList.add('error');
                }

                if(error.errors.emailUser){
                    emailUser.classList.add('error');
                }
            });
        }

    }



    /**
     * Удаление прикрепленных файлов к сообщению
     * @param str
     */
    static deleteFile(str){
        const elem = document.querySelector(str);
        const body = document.getElementById('formEmail');
        if(str === '.offer_pdf'){
            body.dataset.offer = 'false';
        }
        if(str === '.card_company'){
            body.dataset.card = 'false';
        }
        elem.remove();
    }

    /**
     * Прогресс бар
     * @param event
     */
    static progress(event) {
        const size = event.target.getAttribute('data-size'); // Используем target для доступа к элементу
        const progress = document.querySelector('.progress_bar_client');

        let span = document.querySelectorAll('.span_progress');
            span.forEach(item=>{
                item.classList.remove('active_progress');
            })

        if (size) {
            event.target.classList.add('active_progress');
            progress.style.width = size + '%';
            if (this.#numStatus(parseInt(size)) === 'new'){
                this.addStatusCompany('new');
            }
            if(this.#numStatus(parseInt(size)) === 'trash' || this.#numStatus(parseInt(size)) === 'client'){
                this.#searchActive(size);
            }
            if (this.#numStatus(parseInt(size)) === 'offer'){
                this.getMassage();
                this.modalShow('sentMassage');
                this.addStatusCompany('offer');
            }
            if (this.#numStatus(parseInt(size)) === 'nonCall'){
                const table = document.getElementById('tableCompany');
                const rows = table.querySelectorAll('tr');
                rows.forEach(item=>{
                    if(item.classList.contains('activeCompany')){
                        document.getElementById('todoModel').dataset.id = item.dataset.id;
                    }
                })
                this.addStatusCompany('nonCall');
                Service.addTodo();
            }

            this.editStatus(parseInt(size));
        }
    }

    /**
     * Добавление статуса в таблицу компании
     * @param status
     * @returns {boolean}
     */
    static addStatusCompany(status){
        const table = document.getElementById('tableCompany');
        let tr = table.querySelectorAll('tr');

        if(status === 'offer' || status === 'nonCall'){
            for (let item of tr) {
                if (item.classList.contains('activeCompany')) {
                    let td = item.children[0];
                    td.children[0].innerText = status;
                    return false;
                }
            }
        }else{
            for (let item of tr) {
                if (item.classList.contains('activeCompany')) {
                    let td = item.children[0];
                    td.children[0].innerText = '';
                    return false;
                }
            }
        }
    }

    static getMassage(){
        this.preLoad();

        fetch('cool/getMassage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': this.searchActiveCompany(),
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.getElementById('emailCompany').value = data.emailCompany;
                document.getElementById('emailUser').value = data.email;
                document.getElementById('textEmail').value = data.massage;
                document.getElementById('subject').value = data.subject;
                document.getElementById('offer').innerHTML = '';
                document.getElementById('offer').innerHTML = `
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
                `;
            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    static searchActiveCompany() {
        let table = document.getElementById('tableCompany');
        let tr = table.querySelectorAll('tr');

        // Пройти по всем строкам таблицы и найти активную компанию
        for (let item of tr) {
            if (item.classList.contains('activeCompany')) {
                return item.dataset.id;  // Возвращаем id активной компании
            }
        }

        // Если активная компания не найдена, вернуть null или другое значение
        return null;
    }

    /**
     * Сортировка при удалении активного задания
     * @param size
     * @returns {Promise<void>}
     */
    static async #searchActive(size) {
        const table = document.getElementById('tableCompany');
        const rows = table.querySelectorAll('tr');
        let nextRow;

        // Поиск активной строки
        for (const row of rows) {
            if (row.classList.contains('activeCompany')) {
                // Определяем следующую строку: если есть следующая, выбираем её, иначе — первую строку
                nextRow = row.nextElementSibling ? row.nextElementSibling : rows[0];
                await this.editStatus(parseInt(size)); // Дожидаемся выполнения editStatus
                row.remove(); // Удаляем активную строку
                break; // Прерываем цикл после обработки активной строки
            }
        }

        // Если в таблице остались строки, активируем следующую строку
        if (table.querySelectorAll('tr').length === 0) {
            document.querySelector('.result-blocks').innerHTML = `
            <div class="container">
                <div class="row">
                    <div class="col align-middle" style="text-align: center; margin-top: 50%">
                        <i class="bi bi-incognito" style="font-size: 70px; opacity: 0.4;"></i>
                        <p>Выберете компанию</p>
                    </div>
                </div>
            </div>
        `; // Очистка блока
        } else if (nextRow) {
            // Если в таблице остались строки, активируем следующую строку
            this.#getCompany(nextRow.dataset.id);
            nextRow.classList.add('activeCompany');
        }
    }



    /**
     * Метод смены статуса компании
     * @param status
     */
    static async editStatus(status) {
        this.preLoad();

        try {
            const response = await fetch('cool/editStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    'id': document.querySelector('.infoBlock').dataset.id,
                    'status': this.#numStatus(status)
                }),
            });

            const data = await response.json();
            this.deletePreloader(); // Вызов метода родителя
            this.#logBase(document.querySelector('.infoBlock').dataset.id, 'Смена статуса на: ' + this.#numStatus(status));
        } catch (error) {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        }
    }


    /**
     * Метод статуса
     * @param data
     * @returns {*|null|string}
     */
    static #numStatus(data) {
        const status = {
            'new': 20,
            'nonCall' : 40,
            'offer' : 60,
            'client' : 80,
            'trash': 100
        };

        // Проверяем, является ли `data` ключом в объекте `status`
        if (status.hasOwnProperty(data)) {
            return status[data]; // Возвращаем значение по ключу
        }

        // Если `data` является значением, ищем соответствующий ключ
        for (const [key, value] of Object.entries(status)) {
            if (value === data) {
                return key; // Возвращаем ключ, если значение найдено
            }
        }

        // Если `data` не найдено ни как ключ, ни как значение
        return null;
    }

    /**
     * Добавление данных о компании
     */
    static addInfoCompany(){
        let company = {
            'id' : document.querySelector('.infoBlock').dataset.id,
            'contact': document.querySelector('.contact').value,
            'phone': document.querySelector('.phone').value,
            'email': document.querySelector('.email').value,
            'site': document.querySelector('.site').value,
            'text': document.querySelector('.commentCompany').value,
        }

        this.preLoad();

        fetch('cool/getInfoCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(company),
        }).then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw errorData; // Прокидываем ошибку
                });
            }
            return response.json();
        })
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                this.#logBase(data, 'Обновление данных о компании');
            }).catch(error => {
                this.deletePreloader();
            if (error.errors) {
                if (error.errors.id && error.errors.id[0]) {
                    this.#errorLog('Не выбрана компания');
                }
                if (error.errors.email && error.errors.email[0]) {
                    this.#errorLog('Некорректный email');
                }
                if (error.errors.phone && error.errors.phone[0]) {
                    this.#errorLog('Некорректный номер телефона');
                }
                if (error.errors.site && error.errors.site[0]) {
                    this.#errorLog('Некорректный адрес сайта');
                }
                if (error.errors.text && error.errors.text[0]) {
                    this.#errorLog('Некорректно заполнена графа Комментарий');
                }
            } else {
                this.#errorLog('Произошла неизвестная ошибка');
            }
        });
    }

    /**
     * Добавление класса active
     * @param elem
     */
    static active(elem){
        this.#blockResult();
        this.#removeActive();
        let tr = elem.closest('tr');

        this.#getCompany(tr.dataset.id);
        tr.classList.add('activeCompany');
    }

    /**
     * Метод получения списка компаний
     */
    static getCompanyAll(){
        this.preLoad();

        fetch('cool/getCompanyAll', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'company': true,
            }),
        }).then(response => response.json())
            .then(data => {

                this.deletePreloader(); // Вызов метода родителя

                document.querySelector('.result-blocks').innerHTML = `
                    <div class="container">
                        <div class="row" >
                            <div class="col align-middle" style="text-align: center; margin-top: 50%">
                                <i class="bi bi-incognito" style="font-size: 70px; opacity: 0.4;"></i>
                                <p>Выберете компанию</p>
                            </div>
                        </div>
                    </div>
                `;

                this.#printAll(data);

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Проверка времени на текущий момент
     * @param inputDateTime
     * @returns {boolean}
     */
    static #validateDateTime(inputDateTime) {
        const currentDate = new Date(); // Текущая дата и время
        const inputDate = new Date(inputDateTime); // Преобразуем строку в дату

        if (inputDate < currentDate) {
            throw new Error("Дата и время не могут быть раньше текущего момента.");
        }
        return true;
    }

    /**
     * Фармат даты со временем
     * @param dateTime
     * @returns {string}
     */
    static #formatDateTime(dateTime) {
        // Массив с названиями месяцев
        const months = [
            "января", "февраля", "марта", "апреля", "мая", "июня",
            "июля", "августа", "сентября", "октября", "ноября", "декабря"
        ];

        // Разделяем строку на дату и время
        const [date, time] = dateTime.split(' ');
        const [year, month, day] = date.split('-').map(Number); // Преобразуем в числа
        const [hours, minutes] = time.split(':').map(Number); // Преобразуем в числа

        // Формируем новый формат даты и времени
        return `${day} ${months[month - 1]} ${year} ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }
    /**
     * Метод логирования действий
     */
    static #logBase(id, text) {
        fetch('cool/log', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
                'text': text
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const logItem = document.querySelector('.log-item');

                if (logItem) {
                    this.#printLog(text); // Вызываем printLog только если logItem существует
                }

                if (data !== true) { // Проверяем, что ответ не true, что указывает на ошибку в логике сервера
                    throw new Error('Unexpected response from server');
                }
            })
            .catch(error => {
                this.#errorLog('Ошибка!!! Лог не был сохранен.'); // Выполняется только в случае ошибки
            });
    }


    /**
     * Добавление данных логирования
     * @param text
     */
    static #printLog(text){
        const logItem = document.querySelector('.log-item');

            const log = document.createElement('div');
            log.classList = "col-12 tool";
            log.innerHTML = `
            <div class="row">
                <div class="col-8" style="text-align: start; font-size: 13px;">${text}</div>
                <div class="col-4" style="text-align: end; font-size: 12px;">${this.#getFormattedDateTime()}</div>
            </div>
        `;
            logItem.prepend(log);

    }


    /**
     * Вспомогательный метод логирования
     */
    static #errorLog(text) {
        const body = document.querySelector('.toast-container');
        const newLogError = document.createElement('div');

        // Добавляем классы для отображения тоста
        newLogError.classList.add('toast', 'show');
        newLogError.setAttribute('role', 'alert');
        newLogError.setAttribute('aria-live', 'assertive');
        newLogError.setAttribute('aria-atomic', 'true');

        const time = this.#getFormattedDateTime();

        newLogError.innerHTML = `
        <div class="toast-header">
            <img src="/images/bot.png" class="rounded me-2" alt="..." style="width: 25px">
            <strong class="me-auto">Пересылайка</strong>
            <small class="text-muted">${time}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
        </div>
        <div class="toast-body">${text}

        </div>
    `;

        // Добавляем новый тост в контейнер
        body.append(newLogError);

        // Удаляем тост через 5 секунд
        setTimeout(() => {
            newLogError.classList.remove('show');
            newLogError.addEventListener('transitionend', () => newLogError.remove());
        }, 5000);
    }

    /**
     * получение даты и время
     * @returns {string}
     */
    static #getFormattedDateTime() {
        const months = [
            "января", "февраля", "марта", "апреля", "мая", "июня",
            "июля", "августа", "сентября", "октября", "ноября", "декабря"
        ];

        const date = new Date();
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        return `${day} ${month} ${year} ${hours}:${minutes}`;
    }

    /**
     * Вспомогательный метод запроса данных о компании
     * @param id
     */
    static #getCompany(id){
        this.preLoad();

        this.getTodo(id);

        fetch('cool/getCompany', {
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
                if(data['company']){
                    this.#print(data['company']);
                }

                this.#printAllInfoCompany(data['info']);



                if(data['log']){
                    this.#printLogCompany(data['log']);
                }

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Вспомогательный метод вывода данных о компании
     * @param data
     */
    static #print(data){
        document.querySelector('.infoBlock').dataset.id= data[0].id;
        document.querySelector('.innInfoBlock').innerHTML = `<a href="https://yandex.ru/search/?text=${data[0].inn}" target="_blank" rel="noopener noreferrer">${data[0].inn}</a>`;
        document.querySelector('.addressInfoBlock').innerHTML = data[0].address;

        let span = document.querySelectorAll('.span_progress');
        span.forEach(item=>{
            item.classList.remove('active_progress');
        })
        span.forEach(item=>{

            if(parseInt(item.dataset.size) === this.#numStatus(data[0].status)){
                item.classList.add('active_progress');
            }
        })
        document.querySelector('.progress_bar_client').style.width = this.#numStatus(data[0].status) + '%';
    }

    static #printAllInfoCompany(data){
        document.querySelector('.contact').value = '';
        document.querySelector('.phone').value = '';
        document.querySelector('.email').value = '';
        document.querySelector('.site').value = '';
        document.querySelector('.commentCompany').value = '';
        if(data[0]){
            document.querySelector('.contact').value = data[0].name_contact;
            document.querySelector('.phone').value= data[0].phone_contact;
            document.querySelector('.email').value= data[0].email_contact;
            document.querySelector('.site').value= data[0].sait_company;
            document.querySelector('.commentCompany').value= data[0].info_company;
            this.countTextTextarea('textareaComment', 'textareaCount');
        }

        // $('.phone').mask("+7 (9999) 999 99 99? доб 99999");
    }

    /**
     * вывод логов
     * @param data
     */
    static #printLogCompany(data){
        const logItem = document.querySelector('.log-item');
        logItem.innerHTML = '';
        for(let i = 0; i<data.length; i++){
            const log = document.createElement('div');
            log.classList = "col-12 tool";
            log.innerHTML = `
            <div class="row">
                <div class="col-8" style="text-align: start; font-size: 13px;">${data[i].info}</div>
                <div class="col-4" style="text-align: end; font-size: 12px;">${this.#formatDateTime(data[i].date_log)}</div>
            </div>
        `;
            logItem.append(log);
        }
    }

    /**
     * Вспомогательный метод вывода компаний
     * @param data
     */
    static #printAll(data){
        const block = document.getElementById('tableCompany');
        for(let i = 0; i<data.length; i++){
            let tr = document.createElement('tr');
            tr.dataset.id = data[i].id;
            let count = ''
            if (data[i].todo_count > 0){
                count = data[i].todo_count;
            }

            let status = '';
            if(data[i].status === 'offer' || data[i].status === 'nonCall'){
                status =data[i].status;
            }
            tr.innerHTML = `
                <td data-action="active" class="tdCompany">
                    ${data[i].name}
                    <span class="badge text-bg-primary" >${status}</span>
                    <span class="badge count_todo text-bg-primary" >${count}</span></td>
            `;
            block.append(tr);
        }
    }

    /**
     * Удаление класса active
     */
    static #removeActive(){
        const block = document.getElementById('tableCompany');
        let tr = block.querySelectorAll('tr');
        tr.forEach(item=>{
            item.classList.remove('activeCompany');
        })
    }


    static #blockResult(){
        const block = document.querySelector('.result-blocks');
        const details = document.createElement('div');
        details.classList.add("mb-3");
        details.innerHTML = `
                        <div class="row bg-body-tertiary border rounded-3 p-2">
                            <div class="container infoBlock">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-1 mt-2"> <!-- Определяем внутренний блок как строку -->
                                            <div class="col-3 infoTitle">ИНН:</div>
                                            <div class="col-9 infoDis border innInfoBlock" style="min-height: 30px"></div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Адрес Юрид.:</div>
                                            <div class="col-9 infoDis border addressInfoBlock" style="min-height: 43px"></div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Контакт:</div>
                                            <input class="col-9 infoDis border contact">
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Телефон:</div>
                                            <input class="col-9 infoDis border phone">
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">E-mail:</div>
                                            <input class="col-9 infoDis border email">
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-3 infoTitle">Сайт:</div>
                                            <input class="col-9 infoDis border site">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3 mt-3" style="position: relative">
                                            <label for="exampleFormControlTextarea1" class="form-label">Комментарий</label>
                                            <textarea id="textareaComment" class="form-control mb-2 commentCompany" data-action="count" style="height: 150px; resize: none;" data-enter="setCaret"></textarea>
                                            <div id="textareaCount" class="pleacholderText" style="width: 100%; height: 25px; color: #5f6062; position: absolute;top: 69%;left: 2%;">Введено 0 из 255 символов</div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-action="sent">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-body-tertiary border rounded-3 p-2 mt-3">
                            <div class="col justify-content-center tableCheck">
                                <h6>Статус</h6>
                                <div id="progress" class="ProgressBar">
                                    <div class="row">
                                        <div class="col labelProgress">
                                            <span class="span_progress" data-action="progress" data-size="20">Новая</span>
                                        </div>
                                        <div class="col labelProgress">
                                            <span class="span_progress" data-action="progress" data-size="40">Недозвон</span>
                                        </div>
                                        <div class="col labelProgress">
                                            <span class="span_progress" data-action="progress" data-size="60">Ком.пред</span>
                                        </div>
                                        <div class="col labelProgress">
                                            <span class="span_progress" data-action="progress" data-size="80">Клиент</span>
                                        </div>
                                        <div class="col labelProgress">
                                            <span class="span_progress" data-action="progress" data-size="100">Мусор</span>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress_bar_client progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-body-tertiary border rounded-3 p-2 mt-3 ">
                            <div class="col justify-content-center col-12 col-md-6">
                                <div class="row">
                                    <div class="col-9"><h6>Активные задания</h6></div>
                                    <div class="col addTodo" style="text-align: end; font-size: 14px;" data-action="todoAdd"><i class="bi bi-pen" ></i>Добавить</div>
                                </div>
                                <ul class="list-group" id="todoList">

                                </ul>
                            </div>
                            <div class="col justify-content-center col-12 col-md-6">
                                <h6>История изминений</h6>
                                <div class="list-group">
                                    <div class="list-group-item log">
                                        <div class="row log-item" style="max-height: 52vh; overflow: scroll;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        block.innerHTML = '';
        block.append(details);
    }


}
