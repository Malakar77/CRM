import {UserService} from "../script.js";


export class Service extends UserService{

    /**
     * Инициализация календаря и заполнение данных
     */
    static calendar()
    {
        const calendarEl = document.getElementById('calendar');
        const deleteButton = document.getElementById('delete-event');
        deleteButton.disabled = true;
        const addButton = document.getElementById('add-event');
        let selectedEvent = null;
        let idEvent = null;
        // Создание календаря
        this.calendarInstance = new FullCalendar.Calendar(calendarEl, {
            locale: 'ru',
            headerToolbar: {center: 'dayGridMonth,timeGridWeek,timeGridDay'},
            buttonText: {
                dayGridMonth: 'Месяц',
                timeGridWeek: 'Неделя',
                timeGridDay: 'День'
            },
            eventClick: function (info) {
                if (selectedEvent) {
                    selectedEvent.setProp('backgroundColor', '#3788d8'); // Возвращаем предыдущий цвет
                }
                selectedEvent = info.event;
                idEvent = info.event.id;
                info.event.setProp('backgroundColor', '#ff5733');
                deleteButton.disabled = false; // Активируем кнопку удаления
            }
        });

        const calendar = this.calendarInstance; // Для удобства использования

        // Получение событий
        fetch('/main/getActiveTodo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(response => response.json())
            .then(data => {
                this.#printTodo(data)
                data.forEach(item => {
                    let title = item.title;

                    if (item.name !== null) {
                        title = item.name + ' ' + item.title;
                    }

                    calendar.addEvent({
                        id: item.id,
                        title: title,
                        start: new Date(item.start.replace(' ', 'T')),
                        end: new Date(item.end.replace(' ', 'T')),
                        allDay: item.allDay,
                        backgroundColor: item.important,
                    });
                });
                calendar.render();
            });

        // Удаление события через кнопку
        deleteButton.addEventListener('click', function () {
            if (selectedEvent) {
                fetch('/main/deleteTodo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        'id': selectedEvent.id,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        selectedEvent.remove(); // Удаляем событие из календаря
                        selectedEvent = null;
                        deleteButton.disabled = true;
                        document.querySelectorAll('.dis_block').forEach(item=>{
                            if (item.dataset.id === idEvent) {
                                item.closest('.row').remove();
                            }
                        })
                    })
                    .catch(error => console.error('Ошибка при удалении события:', error));
            }
        });

    }

    /**
     * Добавление нового события
     */
    static addTodo()
    {
        const model = document.getElementById('todoModel');
        model.querySelector('.modal-title').innerText = 'Добавить задание';
        model.querySelector('.modal-body').innerHTML = `
            <label for ="basic-url" class="form-label">Начало</label>
            <div class="input-group mb-3">
                <input type="datetime-local"  id="start_task" class="form-control" placeholder="Username" aria-label="Username">
            </div>
            <label for ="basic-url" class="form-label">Конец</label>
            <div class="input-group mb-3">
                <input type="datetime-local" id="end_task" class="form-control">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="allDay" data-action="allDay">
                <label class="form-check-label" for ="flexCheckDefault">
                Весь день
                </label>
            </div>
            <div class="mt-3">
                <label for ="ColorInput" class="form-label">Цвет</label>
                <input type="color" class="form-control form-control-color" id="ColorInput" value="#563d7c" title="Choose your color">
            </div>
            <div class="mb-3 mt-3">
                <label for ="title_task" class="form-label">Задача</label>
                <textarea class="form-control" id="title_task" rows="3"></textarea>
            </div>
        `;
        const footer = model.querySelector('.modal-footer');
        footer.innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-action="addTask">Сохранить</button>
            `;
                this.modalShow('todoModel');
    }

    /**
     * Блокировка при выборе "весь день"
     * @param elem
     */
    static blockTask(elem)
    {
        const input = document.getElementById('end_task');
        if (elem.checked === true) {
            input.disabled = true;
            if (input.classList.contains('error')) {
                input.classList.remove('error');
            }
            input.value = '';
        } else {
            input.disabled = false
        }

    }

    static timeNow()
    {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }


    static validateAddForm()
    {
        let form = {
            title: document.getElementById('title_task'),
            start: document.getElementById('start_task'),
            end: document.getElementById('end_task'),
            color: document.getElementById('ColorInput'),
        };

        let error = false;

        for (let formKey in form) {
            if (formKey === 'end' && document.getElementById('allDay').checked === true) {
                form[formKey].classList.remove('error');
                continue;
            }

            if (formKey === 'end' && form[formKey].value < document.getElementById('start_task').value && document.getElementById('allDay').checked !== true) {
                form[formKey].value = document.getElementById('start_task').value;
                error = true;
            }

            if (formKey === 'start' && form[formKey].value < this.timeNow()) {
                form[formKey].value = this.timeNow();
                error = true;
            }

            if (form[formKey].value.trim() === '') {
                form[formKey].classList.add('error');
                error = true;
            } else {
                form[formKey].classList.remove('error');
            }
        }

        if (error === true) {
            return false;
        }

        let task = {};
        for (let formKey in form) {
            task[formKey] = form[formKey].value.trim();
        }

        task.allDay = document.getElementById('allDay').checked === true;

        return task;
    }



    /**
     * Добавление нового события
     * @returns {boolean}
     */
    static addTask()
    {

        let task = this.validateAddForm();
        task.id_company = null;
        if (!task) {
            // Если валидация не прошла, можно показать сообщение об ошибке
            console.log('Ошибка: форма заполнена некорректно.');
            return false;
        }

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
                this.printTask(data);

            })
            .catch(error => {
                this.deletePreloader(); // Удаляем прелоадер
                this.modalShow('error'); // Показываем сообщение об ошибке
            });

    }

    static printTask(data)
    {
        this.modalHide('todoModel');

        this.calendarInstance.addEvent(data);

        const table = document.getElementById('active_todo_list');

        const date = new Date(data.start);

        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };

        const formattedDate = date.toLocaleString('ru-RU', options).replace(',', ' в');

            let item = document.createElement('div');
        item.classList = "mt-1 todo_elem dis_block";
        item.dataset.id = data.id;
        item.style.borderLeft = '6px Solid' + data.color;
            // item.classList = "row ps-2 pe-1 mt-1 mb-1 rounded-3 todo_elem";
            item.innerHTML = `

                        <div class="row title_todo_position mt-1">
                            <div class="col-7 todo_company">Задача</div>
                            <div class="col time">
                                ${formattedDate}
                            </div>
                        </div>
                        <div class="row bg-body-tertiary discript">
                            <div class="col-12 todo">
                                ${data.title}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-grid gap-2 d-md-block mb-2">
                                <div class="col">
                                    <button type="button" class="btn btn-primary btn-sm" data-action="delete">Закрыть</button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-action="delayTodo">Отложить</button>
                                </div>
                            </div>
                        </div>

                `;
            table.append(item);
    }



    /**
     * Удаление события
     * @param elem
     */
    static deleteTodo(elem)
    {
        const element = elem.target.closest('.dis_block'); // Находим элемент DOM
        const eventId = element.dataset.id; // Получаем ID события
        this.preLoad();

        fetch('/main/deleteTodo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': eventId,
            }),
        })
            .then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Удаляем прелоадер

                // Удаляем DOM-элемент
                element.closest('.todo_elem').remove();

                // Удаляем событие из календаря
                const event = this.calendarInstance.getEventById(eventId); // Находим событие по ID
                if (event) {
                    event.remove(); // Удаляем событие из календаря
                }
            })
            .catch(error => {
                this.deletePreloader(); // Удаляем прелоадер
                this.modalShow('error'); // Показываем сообщение об ошибке
            });
    }

    /**
     * Редактирование активного задания
     */
    static setTodo()
    {
        if (document.getElementById('textTodo').value.trim() === '') {
            document.getElementById('textTodo').classList.add('error');
            return false;
        } else {
            document.getElementById('textTodo').classList.remove('error');
        }

        if (document.getElementById('todoDate').value.trim() === '') {
            document.getElementById('todoDate').classList.add('error');
            return false;
        } else {
            document.getElementById('todoDate').classList.remove('error');
        }

        if (this.#validateDateTime(document.getElementById('todoDate').value)) {
            this.preLoad();
            fetch('/main/setTodo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    'id'    : document.getElementById('textTodo').dataset.id,
                    'text'  : document.getElementById('textTodo').value,
                    'time'  : document.getElementById('todoDate').value
                }),
            }).then(response => response.json())
                .then(data => {
                    this.deletePreloader(); // Вызов метода родителя

                    const todo = document.querySelectorAll('.dis_block');

                    todo.forEach(item=>{
                        if (parseInt(item.dataset.id) === data.id) {
                            item.querySelector('.todo').innerText = data.title;
                        }
                    })

                    const event = this.calendarInstance.getEventById(data.id); // Находим событие по ID

            if (event) {
                // Обновляем свойства события
                event.setProp('title', data.title); // Обновляем заголовок

                // Изменяем дату и время
                const endDate = new Date(data.end); // Преобразуем строку времени в объект Date
                event.setEnd(endDate); // Устанавливаем новое время окончания

                // Обновляем расширенные свойства
                event.setExtendedProp('description', 'Новое описание'); // Обновляем описание
            }

                    this.modalHide('todoModel');

                }).catch(error => {
                    this.deletePreloader(); // Вызов метода родителя
                    this.modalShow('error'); // Вызов метода родителя
                });
        }
    }

    /**
     * Заполнение формы редактирования
     * @param elem
     */
    static delayTodo(elem)
    {
        const model = document.getElementById('todoModel');
        model.querySelector('.modal-body').innerHTML = `
            <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="textTodo" spellcheck="true" lang="ru" rows="3" style="height: 100px"></textarea>
                            <label for ="floatingTextarea2">Введите текст задания</label>
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
        `;

        const footer = model.querySelector('.modal-footer');
        footer.innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary" data-action="setTodo">Сохранить</button>
        `;
        const block = elem.target.closest('.dis_block');
        document.getElementById('textTodo').dataset.id = block.dataset.id;
        document.getElementById('textTodo').value = block.querySelector('.todo').innerText;
        document.getElementById('todoDate').value = '';
        this.modalShow('todoModel');
    }

    /**
     * Формат времени из 2024-10-05 11:52 в 5 ноября 2024 г. в 11:52
     * @param inputDateTime
     * @returns {string}
     * @constructor
     */
    static Time(inputDateTime)
    {
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false };
        const date = new Date(inputDateTime); // Преобразуем строку в объект Date
        const formattedDate = date.toLocaleString('ru-RU', options); // Форматируем дату в соответствии с русскими стандартами
        return formattedDate.replace('', ' ').replace(' ', ' ');
    }

    /**
     * Формат времени из 5 ноября 2024 г. в 11:52 в 2024-10-05 11:52
     * @param inputDateTime
     * @returns {string|null}
     */
    static reTime(inputDateTime)
    {
        // Упрощенное регулярное выражение для извлечения частей даты и времени
        const datePattern = /(\d{1,2})\s+([а-яА-Я]+)\s+(\d{4})\s*г\.\s*в\s*(\d{2}):(\d{2})/;
        // Словарь для преобразования русских месяцев в числовой формат
        const months = {
            'января': '01', 'февраля': '02', 'марта': '03', 'апреля': '04',
            'мая': '05', 'июня': '06', 'июля': '07', 'августа': '08',
            'сентября': '09', 'октября': '10', 'ноября': '11', 'декабря': '12'
        };
        // Применяем регулярное выражение к строке
        const match = inputDateTime.match(datePattern);
        if (!match) {
            return null;
        }
        // Извлекаем части даты
        const day = match[1].padStart(2, '0');
        const month = months[match[2].toLowerCase()];
        const year = match[3];
        const hours = match[4];
        const minutes = match[5];

        if (!month) {
            return null; // Проверка на наличие месяца
        }
        return `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    /**
     * Проверка времени на текущий момент
     * @param inputDateTime
     * @returns {boolean}
     */
    static #validateDateTime(inputDateTime)
    {
        const currentDate = new Date(); // Текущая дата и время
        const inputDate = new Date(inputDateTime); // Преобразуем строку в дату

        if (inputDate < currentDate) {
            document.getElementById('errorTodo').innerHTML = "Дата и время не могут быть раньше текущего момента.";
            return false;
        }
        return true;
    }

    /**
     * Вспомогательный метод получения заданий
     * @param data
     */
    static #printTodo(data)
    {
        const table = document.getElementById('active_todo_list');
        table.innerHTML = '';
        let name = '';

        for (let i = 0; i<data.length; i++) {
            let item = document.createElement('div');
            item.classList = "mt-1 todo_elem dis_block";
            item.dataset.id = data[i].id;
            item.style.borderLeft = '6px Solid' + data[i].important;
            name = data[i].name;
            if (data[i].name === '') {
                name = 'Задача';
            }
            item.innerHTML = `
                                <div class="row title_todo_position mt-1">
                                    <div class="col-7 todo_company">${name}</div>
                                    <div class="col time">
                                        ${this.#formatDateTime(data[i].start)}
                                    </div>
                                </div>
                                <div class="row bg-body-tertiary discript">
                                    <div class="col-12 todo">
                                        ${data[i].title}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-grid gap-2 d-md-block mb-2">
                                        <div class="col">
                                            <button type="button" class="btn btn-primary btn-sm" data-action="delete">Закрыть</button>
                                            <button type="button" class="btn btn-secondary btn-sm" data-action="delayTodo">Отложить</button>
                                        </div>
                                    </div>
                                </div>

            `;
            table.append(item);
        }
    }

    /**
     * Фармат даты со временем
     * @param dateTime
     * @returns {string}
     */
    static #formatDateTime(dateTime)
    {
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
        return `${day} ${months[month - 1]} ${year} г. в ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }
}

