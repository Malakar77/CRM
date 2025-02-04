import * as bootstrap from "bootstrap";

export class UserService {


    /**
     * Перевод на новую строку
     * @param textareaElement
     */
    static insertNewLineAtCaret(textareaElement)
    {
        const start = textareaElement.selectionStart;
        const end = textareaElement.selectionEnd;

        // Вставляем новую строку в текущее положение каретки
        const textBeforeCaret = textareaElement.value.substring(0, start);
        const textAfterCaret = textareaElement.value.substring(end);

        // Обновляем значение и перемещаем каретку
        textareaElement.value = textBeforeCaret + "\n" + textAfterCaret;
        textareaElement.selectionStart = textareaElement.selectionEnd = start + 1; // Ставим каретку после новой строки
        textareaElement.focus();
    }


    /**
     * Метод валидации формы
     */
    static validateForm(elem, buttonClass)
    {
        const form = document.getElementById(elem);
        let inputs = form.querySelectorAll('input');
        let isValid = true; // Флаг для отслеживания валидности формы

        inputs.forEach(item => {
            item.value = item.value.trim(); // Убираем пробелы
            let inputValue = item.value; // Значение инпута
            let lengthInput = 50; // Максимальная длина по умолчанию

            // Проверка на класс "phone"
            if (item.classList.contains('phone')) {
                lengthInput = 20;
            }

            // Валидация длины
            if (inputValue.length === 0 || inputValue.length > lengthInput) {
                item.nextElementSibling.innerHTML = `Ограничение ввода до ${lengthInput} символов`;
                item.classList.add('emptyInput');
                item.nextElementSibling.style.color = 'red';
                isValid = false; // Форма не валидна, если хотя бы один инпут не соответствует
            } else {
                item.nextElementSibling.innerHTML = `Не более ${lengthInput} символов`;
                item.nextElementSibling.style.color = '#a7abae';
                item.classList.remove('emptyInput');
            }
        });

        // Включаем или отключаем кнопку submit в зависимости от валидности формы
        document.querySelector(buttonClass).disabled = !isValid;
    }

    /**
     * Статический метод для получения данных о пользователе.
     * @returns {Promise<Object>} Возвращает промис с данными пользователя.
     */
    static async getUserData()
    {
        try {
            const response = await fetch('/api/user-data');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
        }
    }

    /**
     * Статический метод для выхода пользователя.
     * Добавляет обработчик события на клик по элементу.
     */
    static initExitUser()
    {
        const exitUserButton = document.querySelector('.exitUser');

        if (exitUserButton) {
            exitUserButton.addEventListener('click', async() => {
                try {
                    const response = await fetch('/api/logout',{
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    window.location.href = '/';
                } catch (error) {
                    console.error('Error logging out:', error);
                }
            });
        }
    }

    /**
     * Статический метод для добавления прелоадера
     */
    static preLoad()
    {
        let div = document.createElement('span');
        div.className = "loader";
        document.querySelector('body').append(div);
    }

    static blockPreLoad(name)
    {
        let div = document.createElement('span');
        div.className = "loader";
        document.querySelector(name).append(div);
    }
    /**
     * Статический метод для удаления прелоадера
     */
    static deletePreloader()
    {
        if (document.querySelector('.loader')) {
            document.querySelector('.loader').remove();
        }
    }

    /**
     * Статический метод открытия модельного окна
     */
    static modalShow(name)
    {
        const myModal = new bootstrap.Modal(document.getElementById(name));
// Открываем модальное окно
        myModal.show();
    }

    /**
     * Статический метод закрытия модельного окна
     */
    static modalHide(name)
    {
        const modalElement = document.getElementById(name);
        const myModal = bootstrap.Modal.getInstance(modalElement); // Получаем существующий экземпляр

        if (myModal) {
            myModal.hide(); // Закрываем модальное окно
        }
    }

    /**
     * Статический метод вывода пагинации
     * @param data массив архитектуры страниц
     * @param currentPage текущая страница
     */
    static paginatorNav(data, currentPage)
    {
        const paginatorNav = document.querySelector('.paginatorNav');

        if (data && data.length > 1) {
            let paginationHtml = `
            <nav aria-label="Page navigation example">
                <ul class="pagination">
            `;

            // Если страниц больше 10, добавляем стрелку "назад"
            if (data.length > 10 && currentPage !== 1) {
                paginationHtml += `
                <li class="page-item">
                    <a class="page-link" data-action="pageLink" data-href="${currentPage - 1}">&larr;</a>
                </li>
                `;
            }

            // Генерация кнопок для страниц
            data.forEach(page => {
                if (page !== currentPage && page !== "...") {
                    paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" data-action="pageLink" data-href="${page}">${page}</a>
                    </li>
                    `;
                } else if (page === currentPage) {
                    paginationHtml += `
                    <li class="active">
                        <a class="page-link" data-action="pageLink" data-href="${page}">${page}</a>
                    </li>
                    `;
                } else if (page === "...") {
                    paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" class="page_dots" data-action="pageLink">${page}</a>
                    </li>
                    `;
                }
            });

            // Если страниц больше 10, добавляем стрелку "вперед"
            if (data.length > 10 && currentPage < data.length) {
                paginationHtml += `
                <li class="page-item">
                    <a class="page-link" data-action="pageLink" data-href="${currentPage + 1}">&rarr;</a>
                </li>
                `;
            }

            paginationHtml += `
                </ul>
            </nav>
            `;

            paginatorNav.innerHTML = paginationHtml;
        }
    }


    /**
     * Функция форматирования даты 2024-03-01 в формат 01 марта 2024
     * @param dateString
     * @returns {string}
     */
    static formatDate(dateString)
    {
        let months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
        let dateParts = dateString.split("-");
        let res = {};
            res['d'] =  dateParts[2];
            res['y'] =  dateParts[0];
            res['m'] =  months[parseInt(dateParts[1]) - 1];
            res['full'] =  dateParts[2] + " " + months[parseInt(dateParts[1]) - 1] + " " + dateParts[0];
        return res;
    }


    static abbreviateName(fullName)
    {
        // Разделение полного имени на части
        const nameParts = fullName.split(' ');

        // Проверка, что в имени есть как минимум три части
        if (nameParts.length < 3) {
            throw new Error('Имя должно состоять как минимум из трех частей: фамилии, имени и отчества');
        }

        // Извлечение фамилии, имени и отчества
        const lastName = nameParts[0];
        const firstName = nameParts[1];
        const middleName = nameParts[2];

        // Сокращение имени и отчества до первой буквы с точкой
        const abbreviatedFirstName = `${firstName.charAt(0)}.`;
        const abbreviatedMiddleName = `${middleName.charAt(0)}.`;

        // Формирование сокращенного имени
        return `${lastName} ${abbreviatedFirstName} ${abbreviatedMiddleName}`;
    }

    /**
     * Валидация input
     * @param elem input
     * @param classButton кнопка отправки формы
     */
    static validateInput(elem, classButton)
    {
        const input = elem.value;
        let button = document.querySelector(`[${classButton}]`);
        if (input.trim() === '') {
            elem.classList.add('error');
            button.disabled = true;
        } else {
            elem.classList.remove('error');
            button.disabled = false;
        }
    }

    /**
     * получение даты и время
     * @returns {string}
     */
    static getFormattedDateTime()
    {
        const months = [
            "января", "февраля", "марта", "апреля", "мая", "июня",
            "июля", "августа", "сентября", "октября", "ноября", "декабря"
        ];

        const date = new Date();
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        return `${day} ${month} ${year} ${hours}:${minutes}`;
    }

    /**
     * Разбитие суммы на 3 знака 100000 на 100 000
     * @param number
     * @returns {string}
     */
    static spaceDigits(number)
    {
        return number.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    }

    /**
     * обратное разбитие из 100 000 в 100000
     * @param numberWithSpaces
     * @returns {*}
     */
    static removeSpaces(numberWithSpaces)
    {
        return numberWithSpaces.replace(/\s/g, '');
    }

    /**
     * перевод в микрорубль
     * @param val
     * @returns {number}
     */
    static microRuble(val)
    {
        return val * 1000000;
    }

    /**
     * обратный перевод из микрорубля
     * @param val
     * @returns {number}
     */
    static remMicroRuble(val)
    {
        return val / 1000000;
    }

    /**
     * Функция форматирования строки в float
     * @param str
     * @returns {string}
     */
    static extractFloat(str)
    {
        // Удаляем все символы кроме цифр, запятых или точек
        let cleanedStr = str.replace(/[^0-9,.]/g, '');

        // Заменяем запятые на точки
        cleanedStr = cleanedStr.replace(',', '.');

        cleanedStr = parseFloat(cleanedStr);
        // Извлекаем десятичное число из строки
        return cleanedStr.toFixed(2);
    }

    /**
     * Функция обрезки количества символов
     */
    static countTextTextarea(idTextarea, idComment)
    {
        let textarea = document.getElementById(idTextarea);

        let textLength = this.count(idTextarea);
        let maxLength = 255; // Максимальная длина текста

        if (textLength > maxLength) {
            textarea.value = textarea.value.substring(0, maxLength);
            textLength = maxLength;
        }

        document.getElementById(idComment).innerHTML = `Введено ${textLength} из ${maxLength} символов`;
    }

    /**
     * Функция подсчета количество введенных символов
     */
    static count(textarea)
    {
        return document.getElementById(textarea).value.length;
    }


    /**
     * Статический метод закрытия Offcanvas
     */
    static offcanvasHide(name)
    {
        const offcanvasElement = document.getElementById(name);
        const myOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Получаем существующий экземпляр

        if (myOffcanvas) {
            myOffcanvas.hide(); // Закрываем Offcanvas
        }
    }

    /**
     * Статический метод открытия Offcanvas
     */
    static offcanvasShow(name)
    {
        const offcanvasElement = document.getElementById(name);
        const myOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement); // Получаем существующий экземпляр

        if (myOffcanvas) {
            myOffcanvas.show(); // Закрываем Offcanvas
        }
    }

    /**
     * Получение get параметра
     * @returns {string}
     */
    static getParam(key)
    {
        try {
            // Получаем текущий URL
            const url = window.location.href;
            // Проверяем, содержит ли URL символ "?"
            if (!url.includes('?')) {
                return null; // Если параметров нет, возвращаем null
            }
            // Извлекаем строку запроса
            const queryString = url.split('?')[1];
            // Проверяем, есть ли после "?" параметры
            if (!queryString) {
                return null; // Если параметры отсутствуют, возвращаем null
            }
            // Создаем объект URLSearchParams
            const params = new URLSearchParams(queryString);
            // Возвращаем значение параметра по ключу
            return params.get(key);
        } catch (error) {
            console.error('Ошибка при разборе параметров URL:', error);
            return null; // Возвращаем null в случае любой ошибки
        }
    }
}

