
import { Service} from "./class/mainModel.js";

document.addEventListener('DOMContentLoaded', ()=>{

    Service.calendar();

    new clickController(document.querySelector('body'),  Service);
    new changeController(document.querySelector('body'),  Service)
    new keyDownController(document.querySelector('body'),  Service)

})

class clickController {
    constructor(elem, service)
    {
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Удаление активного задания
     * @param elem
     */
    delete(elem)
    {
        this.service.deleteTodo(elem);
    }

    addTodo()
    {
        this.service.addTodo();
    }

    /**
     * Обновление активного задания
     */
    setTodo()
    {
        this.service.setTodo();
    }

    /**
     * Заполнение формы и открытие модельного окна редактирования
     * @param elem
     */
    delayTodo(elem)
    {
        this.service.delayTodo(elem);
    }

    addTask()
    {
        this.service.addTask();
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
    constructor(elem, service)
    {
        this.service    = service;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    allDay(elem)
    {
        this.service.blockTask(elem.target);
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
    constructor(elem, service)
    {
        this.service    = service;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
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
