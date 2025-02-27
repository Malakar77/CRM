import {Service} from "./class/Auth.js";

document.addEventListener('DOMContentLoaded', (e)=>{

    new clickController(document.querySelector('body'), Service);
    new keyDownController(document.querySelector('body'), Service);
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


class keyDownController {
    constructor(elem, service)
    {
        this.service = service;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }


    sent()
    {
        this.service.validateFormLogin();
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
