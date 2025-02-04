import {Profile} from "./class/profile.js";
import {UserService} from "./script.js";

document.addEventListener('DOMContentLoaded', ()=>{
    UserService.countTextTextarea('text_signature', 'count_text');

    new clickController(document.querySelector('body'), Profile);
    new inputController(document.querySelector('body'), Profile);
})

class clickController {
    constructor(elem, profile)
    {
        this.profile = profile;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Запись данных о почте
     */
    signature()
    {
        this.profile.setSignature();
    }

    /**
     * Установка аватарки
     */
    setFile()
    {
        this.profile.setAvatar();
    }

    /**
     * Установка имени
     */
    setName()
    {
        this.profile.setName();
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

class inputController {
    constructor(elem, profile)
    {
        this.profile = profile;
        elem.addEventListener('input', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * Подсчет введенных символов
     */
    textarea()
    {
        this.profile.countTextTextarea('text_signature', 'count_text')
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
