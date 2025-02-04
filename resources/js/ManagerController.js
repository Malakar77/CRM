import {UserService} from "./script.js";
import {ManagerModel} from "./class/ManagerClass.js";

document.addEventListener('DOMContentLoaded', function () {
    /**
     * Добавление масок Jquery
     */
    $('#companyProvider').selectize();
    $.mask.definitions['h'] = "[0|1|3|4|5|6|7|9]";
    $(".addPhone").mask("+7 (h99) 999 99 99");
    $(".editPhone").mask("+7 (h99) 999 99 99");

    /**
     * Запрос всех менеджеров поставщиков
     */
    ManagerModel.printManager('all', 1);

    /**
     * вызов класса обработчика кликов
     */
    new clickController(document.querySelector('body'), ManagerModel);

    /**
     * вызов класса обработки событий change
     */
    new changeController(document.querySelector('body'), ManagerModel);

    /**
     * вызов класса по нажатию на enter
     */
    new keyDownController(document.querySelector('body'), ManagerModel);
})

class clickController{

    constructor(elem, manager)
    {
        this.manager    = manager;
        elem.onclick    = this.onClick.bind(this);
    }

    /**
     * Выделение активного элемента
     * @param elem
     */
    activeTd(elem)
    {
        this.manager.activeTr(elem)
    }

    /**
     * Метод открытия модельного окна
     * добавление в select компаний поставщиков
     */
    modal()
    {
        this.manager.searchCompanyProvider('#companyProvider');
        this.manager.modalShow('addManager');
    }

    /**
     * Метод добавление менеджера
     */
    add()
    {
        this.manager.addManager();
    }

    /**
     * Открытие модельного окна и заполнение формы
     * @param elem
     */
    edit(elem)
    {
        this.manager.modalShow('editManager');
        this.manager.fillFormEdit(elem.target);

    }

    /**
     * метод редактирования менеджера
     * @param elem
     */
    editButton(elem)
    {
        this.manager.editForm(elem);
    }

    /**
     * Метод удаления менеджера
     * @param elem
     */
    trash(elem)
    {
        const but = elem.target;
        const id = but.closest('tr').dataset.id;
        this.manager.deleteManager(id, elem.target);

    }

    clear()
    {
        this.manager.clear();
    }
    /**
     * метод перелистывания страниц
     * @param event
     */
    pageLink(event)
    {
        let page = event.target.dataset.href;
        let input = document.querySelector('[data-action="searchChange"]');
        if (input.value === '') {
            this.manager.printManager('all', parseInt(page));
        } else {
            this.manager.printManager(input.value.trim(), parseInt(page));
        }
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
    constructor(elem, manager)
    {
        this.manager    = manager;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * Проверка на наличие данных в форме
     * @param event
     */
    validate(event)
    {
        this.manager.validateInput(event.target, 'data-action="add"');
    }

    /**
     * метод поиска по событию change
     * @param elem
     */
    searchChange(elem)
    {
        let input = elem.target;
        this.manager.printManager(input.value, 1);
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
    constructor(elem, manager)
    {
        this.manager    = manager;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }

    /**
     * Метод поиска по нажатию enter
     * @param elem
     */
    searchChange(elem)
    {
        let input = elem.target;
        this.manager.printManager(input.value, 1);
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
