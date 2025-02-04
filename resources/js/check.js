import {Check, ContextMenu, Service, PriceUpdater} from "./class/check.js";
document.addEventListener('DOMContentLoaded', ()=>{

    const id = Service.getParam('id');
    const check = Service.getParam('check');

    if (id) {
        Service.getDateCompany(id);
        Service.day();
        Service.numberCheckUser();
        Service.allSum();
    }

    if (check) {
        Service.getDataCheck(check);
    }

    Service.getCompanyProvider();

    new clickController(document.querySelector('body'), Check, Service, new ContextMenu("#context-menu", "form_group"));
    new changeController(document.querySelector('body'), Check, Service);
    new inputController(document.querySelector('body'), Check, Service);
    new blurController(document.querySelector('body'), Check, Service);
    new keyDownController(document.querySelector('body'), Check, Service);
    new PriceUpdater();

})

class clickController {
    constructor(elem, check, service, contextMenu)
    {
        this.check = check;
        this.contextMenu = contextMenu;
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    ajaxPosition()
    {
        this.check.ajaxPosition();
    }


    /**
     * Добавление комментария в textarea
     */
    inputComment()
    {
        // Получаем значение из текстового поля и текстовой области
        let input = document.querySelector('.infoInput').value;
        let textarea = document.getElementById('textareaComment');

        // Присваиваем значение переменной textarea
        textarea.value = input.replace(/<br>/g, '\n');
        this.service.countTextTextarea('textareaComment', 'textareaText');
    }

    /**
     * Сохранение комментария
     */
    saveComment()
    {
            // Получаем значение из текстового поля и текстовой области
            let input = document.querySelector('.infoInput').value;
            let textarea = document.getElementById('textareaComment').value;

            // Заменяем все переносы строк в текстовой области на теги <br>
            textarea = textarea.replace(/\n/g, '<br>');

            // Записываем измененное значение обратно в текстовую область
            document.querySelector('.infoInput').value = textarea;
            this.service.modalHide('comment_model');
    }

    /**
     * Удаление позиции
     */
    deleteActivePosition()
    {
        const table = document.getElementById('formKanban');
        let rows = table.querySelectorAll('tr');

        rows.forEach(item => {

            let checkbox = item.querySelector('td:first-child .checkbox');

            if (checkbox && checkbox.checked) {
                checkbox.closest('tr').remove();
                this.contextMenu.toggleMenuOff();
                this.service.allSum();
                const indexPosition = document.querySelectorAll('.spanIndex');
                indexPosition.forEach((div, index) => {
                    // Устанавливаем индекс каждому блоку div
                    div.textContent = index + 1;
                });
            }
        });

        this.service.addActionCheck();
    }

    /**
     * Надбавка в процентах
     */
    plus()
    {
        const up = document.querySelector('input.plus');
        const down = document.querySelector('input.minus');
        up.removeAttribute('readonly'); // Разблокируем
        down.setAttribute('readonly', true); // Блокируем
        down.value = ''; // Очистка
        this.service.allSum();
    }

    /**
     * Скидка в процентах
     */
    minus()
    {
        const up = document.querySelector('input.plus');
        const down = document.querySelector('input.minus');
        down.removeAttribute('readonly'); // Разблокируем
        up.setAttribute('readonly', true); // Блокируем
        up.value = ''; // Очистка
        this.service.allSum();
    }

    /**
     * Удаление компании поставщика
     */
    deleteCompany()
    {
        this.check.deleteCompany();
    }
    /**
     * Добавить компанию поставщика
     */
    addCompanyProvider()
    {
        this.check.addCompanyProvider();
    }

    /**
     * Поиск банка по БИК
     */
    searchBank(elem)
    {
        let element = elem.target;
        const form = element.closest('form');
        let bic = element.previousElementSibling.value.trim();
        this.service.searchBank(form.id, bic);
    }

    /**
     * Поиск компании по ИНН
     */
    searchCompany(elem)
    {
        let element = elem.target;
        const form = element.closest('form');
        let inn = element.previousElementSibling.value.trim();
        this.service.searchCompany(form.id, inn);
    }

    /**
     * Выбор всех позиций и удаление выбора
     */
    setCheckbox()
    {
        this.service.setAllCheckbox();
        this.service.addActionCheck();
    }

    checkbox()
    {
        this.service.addActionCheck();
    }

    /**
     * Метод заполнения текущей даты
     */
    day()
    {
        this.service.day();
    }

    /**
     * Метод добавления позиции
     */
    addPosition()
    {
        this.check.addBlock();
    }

    /**
     * Редактирование компании поставщика
     */
    editCompanyProvider()
    {
        this.check.getEditCompanyProvider();
    }

    /**
     * Обновление компании поставщика
     */
    updateCompany()
    {
        this.check.updateCompany();
    }

    /**
     * Кнопка для добавления номера счета
     */
    numberPlus()
    {
        const input = document.getElementById('inputCheck');
        // Разделяем строку по "/"
        let parts = input.value.split("/");

        // Увеличиваем основное число
        let mainNumber = parts[0].replace(/[^\d]/g, ""); // Извлекаем только цифры
        let prefix = parts[0].replace(/\d/g, ""); // Извлекаем только буквы
        let incrementedMain = parseInt(mainNumber) + 1;

        // Если есть часть после "/", увеличиваем её
        if (parts.length > 1) {
            let subNumber = parseInt(parts[1]) + 1;
            input.value = `${prefix}${mainNumber}/${subNumber}`;
        } else {
            // Если нет части после "/", возвращаем увеличенное основное число
            input.value = `${prefix}${incrementedMain}`;
        }
    }

    /**
     * поле ввода цены и количества
     * @param elem
     */
    input(elem)
    {
        let value = this.service.processValue(elem.target.value);

        // Если значение пустое, присваиваем "0.00"
        if (value === '0.00') {
            value = '';
        }

        // Присваиваем очищенное значение обратно
        elem.target.value = value;

        // Вызываем метод перерасчета
        this.service.allSum();

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
    constructor(elem, check, service)
    {
        this.check = check;
        this.service = service;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * поле ввода цены и количества
     * @param elem
     */
    input(elem)
    {
        // Присваиваем очищенное значение обратно
        let value = this.service.processValue(elem.target.value);

        const formatInput = (value) => {

            // Если значение пустое или невалидное, вернуть "0.00"
            if (!value || isNaN(value)) {
                return "0.00";
            }

            // Преобразуем значение в число и обратно в строку, чтобы избавиться от лишних символов
            value = parseFloat(value).toString();

            // Если значение не содержит десятичной части, добавляем `.00`
            if (!value.includes('.')) {
                return `${value}.00`;
            }
            // Разделяем число на целую и дробную части
            const [integerPart, decimalPart] = value.split('.');

            // Проверяем длину дробной части
            if (decimalPart.length === 2 || decimalPart.length === 3) {
                // Возвращаем число как строку без изменений
                return value;
            } else if (decimalPart.length < 2) {
                // Добавляем недостающие нули до двух знаков после запятой
                return `${integerPart}.${decimalPart.padEnd(2, '0')}`;
            } else {
                // Оставляем только первые три знака после запятой
                return `${integerPart}.${decimalPart.substring(0, 3)}`;
            }
        };

// Пример применения к событию ввода
        elem.target.value = formatInput(elem.target.value);

        // Вызываем метод перерасчета
        this.service.allSum();
    }

    /**
     * выбор НДС и пересчет
     */
    selectNds()
    {
        this.service.allSum();
    }


    numberCheck()
    {
        this.service.generateNumber();
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

class blurController {
    constructor(container, check, service)
    {
        this.check = check;
        this.service = service;

        // Привязываем обработчик события к контейнеру
        container.addEventListener('blur', this.onChange.bind(this), true); // Используем фазу перехвата
    }

    /**
     * поле ввода цены и количества
     * @param elem
     */
    input(elem)
    {
        let value = this.service.processValue(elem.target.value);

        // Если значение равно "0.00", очищаем поле
        if (value === '') {
            value = '0.00';
        }

        // Присваиваем очищенное значение обратно
        elem.target.value = value;

        // Вызываем метод перерасчета
        this.service.allSum();
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
    constructor(elem, check, service)
    {
        this.check = check;
        this.service = service;
        elem.addEventListener('input', this.onChange.bind(this));  // Используем событие change
    }

    countTextarea()
    {
        this.service.countTextTextarea('textareaComment', 'textareaText');
    }

    /**
     * поле ввода цены и количества
     * @param elem
     */
    input(elem)
    {
        // Присваиваем очищенное значение обратно
        elem.target.value = this.service.processValue(elem.target.value);

        // Вызываем метод перерасчета
        this.service.allSum();
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
    constructor(elem, check, service)
    {
        this.check = check;
        this.service = service;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
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





