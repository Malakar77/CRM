import {UserService} from "./script.js";
import {CoolModel} from './class/cool/CoolModel.js';
import {Service} from "./class/mainModel.js";

document.addEventListener('DOMContentLoaded', ()=>{
    /**
     * Получение списка всех компаний
     */
    CoolModel.getCompanyAll();

    /**
     * Классы отслеживания событий
     */
    new clickController(document.querySelector('body'), Service, CoolModel);
    new changeController(document.querySelector('body'), Service, CoolModel)
    new inputController(document.querySelector('body'), UserService, CoolModel)
    new keyDownController(document.querySelector('body'), UserService, CoolModel);
})


class clickController {
    constructor(elem, service, model)
    {
        this.service = service;
        this.model = model;
        elem.onclick = this.onClick.bind(this);
    }

    addTask()
    {
        this.model.addTask();
    }


    /**
     * Добавление Активного задания
     */
    setTodo()
    {
        this.service.addTodo();
    }
    /**
     * Удаление Активного задания
     * @param elem
     */
    deleteTodo(elem)
    {
        this.model.deleteTodo(elem);
    }
    /**
     * Метод отправки коммерческого предложения
     */
    sentEmail()
    {
        this.model.validEmail();
    }

    /**
     *Удаление прикрепленных файлов к сообщению
     * @param elem
     */
    deleteOffer(elem)
    {
        this.model.deleteFile('.offer_pdf');
    }

    /**
     *Удаление прикрепленных файлов к сообщению
     * @param elem
     */
    deleteCardCompany(elem)
    {
        this.model.deleteFile('.card_company');
    }

    todoAdd()
    {
        document.getElementById('todoModel').dataset.id = this.model.searchActiveCompany();
        this.service.addTodo();
    }

    /**
     * Смена статуса компании
     * @param elem
     */
    progress(elem)
    {

        this.model.progress(elem);
    }
    /**
     * Сохранение данных о компании
     */
    sent()
    {
        this.model.addInfoCompany();
    }

    /**
     * Добавление класса active и вывод информации о компании
     * @param elem
     */
    active(elem)
    {
        this.model.active(elem.target)
    }

    /**
     * Метод обработки клика
     * @param event
     */
    onClick(event)
    {
        let action = event.target.dataset.action;
        if (action && typeof this[action] === 'function') {
            this[action](event);
        }
    }

}


class changeController {
    constructor(elem, service, model)
    {
        this.service = service;
        this.model = model;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }


    allDay(elem)
    {
        this.service.blockTask(elem.target);
    }
    /**
     * Поиск компаний
     */
    search()
    {
        this.model.search();
    }

    onChange(event)
    {
        let actionElement = event.target.closest('[data-action]');
        if (actionElement) {
            let action = actionElement.dataset.action;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}

class inputController {
    constructor(elem, service, model)
    {
        this.service = service;
        this.model = model;
        elem.addEventListener('input', this.onChange.bind(this));  // Используем событие change
    }

    count()
    {
        this.model.countTextTextarea('textareaComment', 'textareaCount');
    }

    countTodo()
    {
        const textarea = document.getElementById('textTodo');

        let textLength = textarea.value.length;
        let maxLength = 255; // Максимальная длина текста

        if (textLength > maxLength) {
            textarea.value = textarea.value.substring(0, maxLength);
            textLength = maxLength;
        }
    }


    onChange(event)
    {
        let actionElement = event.target.closest('[data-action]');
        if (actionElement) {
            let action = actionElement.dataset.action;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}


class keyDownController {
    constructor(elem, service, model)
    {
        this.service = service;
        this.model = model;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }

    /**
     * Поиск компаний
     */
    search()
    {
        this.model.search();
    }

    /**
     * Перевод на новую строку
     * @param elem
     */
    setCaret(elem)
    {
        this.service.insertNewLineAtCaret(elem.target);
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

/**
 * Удаление прикрепленного файла в input по нажатию DELETE или BACKSPACE
 */
document.getElementById('fileInput').addEventListener('keydown', function (event) {
    if (event.key === "Delete") {
        event.preventDefault(); // Предотвращаем стандартное поведение
        this.value = ""; // Сбрасываем выбранный файл
    }
    if (event.key === "Backspace") {
        event.preventDefault(); // Предотвращаем стандартное поведение
        this.value = ""; // Сбрасываем выбранный файл
    }
});

