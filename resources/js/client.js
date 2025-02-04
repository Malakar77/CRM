import {Client, Service} from "./class/client.js";

document.addEventListener('DOMContentLoaded', ()=>{
    Client.getClient();

    new clickController(document.querySelector('body'), Client, Service);
    new changeController(document.querySelector('body'), Client);
    new inputController(document.querySelector('body'), Client, Service);
    new keyDownController(document.querySelector('body'), Client)
    new dblclickController(document.querySelector('body'), Client, Service)
})

class clickController {
    constructor(elem, client, service)
    {
        this.client = client;
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Вывод блока информации о счета
     * @param elem
     */
    detailsCheck(elem)
    {
        this.client.detailsCheck(elem);
    }

    /**
     * Смена статуса счета
     * @param elem
     */
    progress(elem)
    {
        this.client.progress(elem);
    }

    /**
     * Создать новый счет
     */
    addCheck()
    {
        this.client.addCheck();
    }

    /**
     * Выбор компании
     * @param elem
     */
    active(elem)
    {
        this.client.active(elem);
    }

    /**
     * Добавление класса Active для выбранной компании
     * @param elem
     */
    activeTr(elem)
    {
        const table = document.querySelector('tbody.ui-sortable');

        let tr = table.querySelectorAll('tr');

        tr.forEach(item=>{
            item.classList.remove('active');
        })
        let element = elem.target.closest('tr')
        element.classList.add('active');
    }

    /**
     * Отправка счета на согласование
     */
    sentMessage()
    {
        this.client.sentMessage();
    }

    /**
     * Загрузка данных из файла
     */
    sentFileExel()
    {
        this.client.sentFileExel();
    }

    /**
     * Добавление из файла
     */
    addCheckFile()
    {
        this.client.addCheckFile();
    }

    /**
     * Добавление комментария
     */
    sent()
    {
        this.client.sent();
    }

    /**
     * Вывод всех компаний
     * @param elem
     */
    allCompany(elem)
    {
        const target = elem.target;
        if (target.checked === true) {
            this.client.allCompany();
        } else {
            this.client.getClient();
        }
    }

    /**
     * Вывод данных о компании в окно редактирования
     */
    editCompany()
    {
        this.client.editCompany();
    }

    /**
     * Сохранение формы редактирования
     */
    saveEditCompany()
    {
        this.client.saveEditCompany();
    }

    /**
     * Поиск по ИНн
     */
    searchForInn()
    {
        this.client.searchForInn();
    }

    /**
     * Вывод списка пользователей для добавления компании
     */
    addCompanyClient()
    {
        this.client.addCompanyClient();
    }

    setClient()
    {
        this.client.setClient();
    }

    /**
     * Метод обработки клика
     * @param event
     */
    onClick(event)
    {
        let actionElement = event.target.closest('[data-click]');
        if (actionElement) {
            let action = actionElement.dataset.click;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}

class changeController {
    constructor(elem, client)
    {
        this.client = client;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * Вывод архивных счетов
     * @param elem
     */
    archive(elem)
    {
        if (elem.target.checked) {
            this.client.checkClose(this.client.searchActiveCompany());
        } else {
            this.client.checkNoClose(this.client.searchActiveCompany());
        }
    }

    /**
     * Выбор селект для загрузки из файла
     * @param elem
     */
    optionData(elem)
    {
        this.client.optionData(elem)
    }

    search()
    {
        this.client.search();
    }

    onChange(event)
    {
        let actionElement = event.target.closest('[data-change]');
        if (actionElement) {
            let action = actionElement.dataset.change;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}


class dblclickController {
    constructor(elem, client, service)
    {
        this.client = client;
        this.service = service;
        elem.addEventListener('dblclick', this.onChange.bind(this));
    }

    /**
     * открытие выставленного счета
     * @param elem
     */
    check(elem)
    {
        const tr = elem.target.closest('tr');
        window.location.href = '/check?check=' + tr.dataset.check;
    }

    onChange(event)
    {
        let actionElement = event.target.closest('[data-dblclick]');
        if (actionElement) {
            let action = actionElement.dataset.dblclick;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}

class inputController {
    constructor(elem, client, service)
    {
        this.client = client;
        this.service = service;
        elem.addEventListener('input', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * Подсчет введенных символов
     */
    textarea()
    {
        this.service.countTextTextarea('commentCompany', 'textInfo');
    }

    comment()
    {
        this.service.countTextTextarea('textAreaInput', 'countText');
    }

    onChange(event)
    {
        let actionElement = event.target.closest('[data-input]');
        if (actionElement) {
            let action = actionElement.dataset.input;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}


class keyDownController {
    constructor(elem, client)
    {
        this.client = client;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }

    /**
     * Поиск по компаниям
     */
    search()
    {
        this.client.search();
    }
    /**
     * Обработчик события нажатия клавиш
     */
    keyDown(event)
    {
        if (event.key === 'Enter') {
            event.preventDefault();
            let action = event.target.dataset.enter;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}
