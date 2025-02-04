import {Setting} from "./class/setting.js";
import * as bootstrap from "bootstrap";

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

document.addEventListener('DOMContentLoaded', (e) =>{
    Setting.index();
    new clickController(document.querySelector('body'), Setting);
    new changeController(document.querySelector('body'), Setting);
})


class clickController {
    constructor(elem, Setting)
    {
        this.setting = Setting;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Сохранение данных о пользователе
     */
    save()
    {
        this.setting.save();
    }

    /**
     * модельное окно
     */
    add()
    {
        this.setting.add();
    }

    /**
     * запись новой должности/отдела
     */
    save_post()
    {
        this.setting.save_post();
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
    constructor(elem, Setting)
    {
        this.setting = Setting;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * Вывод информации о пользователе
     */
    userSelection()
    {
        this.setting.userSelection();
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
