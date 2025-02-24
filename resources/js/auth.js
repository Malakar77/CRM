import {Service} from "./class/Auth.js";


document.addEventListener('DOMContentLoaded', (e)=>{

    new clickController(document.querySelector('body'), Service);

})

class clickController {
    constructor(elem, service)
    {
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    sent()
    {
        this.service.validateFormLogin();
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




/**
 * Функция удаления прелоадера.
 * Проверяет наличие элемента с классом 'loader' и удаляет его,
 * а также убирает класс 'sent' у кнопки.
 */
function deleteLoader() {
    // Если есть прелоадер, удаляем его
    if (document.querySelector('.loader')) {
        document.querySelector('.loader').remove();
        document.querySelector('.glow-on-hover').classList.remove('sent');
    }
}
