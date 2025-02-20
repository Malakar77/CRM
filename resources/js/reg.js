import {Service} from "./class/regestration.js";
document.addEventListener('DOMContentLoaded', (e)=>{

    new clickController(document.querySelector('body'), Service);

})

class clickController {
    constructor(elem, service)
    {
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Возвращает на главную страницу
     */
    back()
    {
        window.location.href = '/';
    }

    /**
     * Функция для отправки данных с помощью Fetch API.
     * Отправляет данные формы на сервер, показывает/удаляет прелоадер,
     * обрабатывает ответы сервера и ошибки.
     */
    registration()
    {
        this.service.validateForm();
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





