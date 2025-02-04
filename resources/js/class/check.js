import {UserService} from "../script.js";

export class Service extends UserService{


    static inputComment()
    {
        // Получаем значение из текстового поля и текстовой области
        let input = document.querySelector('.infoInput').value;
        let textarea = document.getElementById('textareaComment').value;

        // Заменяем все переносы строк в текстовой области на теги <br>
        textarea = textarea.replace(/\n/g, '<br>');

        // Записываем измененное значение обратно в текстовую область
        document.querySelector('.infoInput').value = textarea;
    }

    /**
     * Вывод списка компаний поставщика
     */
    static getCompanyProvider()
    {
        this.preLoad();

        fetch('/check/getCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'value' : true,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                // Получаем элемент select по его id
                const selectElement = document.getElementById('selectCompany');

                for (let i = 0; i<data.length; i++) {
                    // Создаем новый элемент option
                    const newOption = document.createElement('option');
                    newOption.text = data[i].company_name + ' ' + data[i].bank;
                    newOption.value = data[i].id; // Опционально, можно задать значение для нового варианта

                    // Добавляем новый элемент option в список вариантов выбора select
                    selectElement.add(newOption);
                }

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Функция добавления номера позиции
     * @param divs блок span с номером позиции
     * @returns {number} возвращает номер позиции
     */
    static indexPosition(divs)
    {
        let indexSp = 0;
        // Перебираем каждый блок div и устанавливаем соответствующий индекс
        divs.forEach((div, index) => {
            // Устанавливаем индекс каждому блоку div
            indexSp = index + 1;
            div.textContent = index + 1;
        });
        return indexSp += 1;
    }




    /**
     * функция заполнения даты
     */
    static day()
    {
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let month = String(today.getMonth() + 1).padStart(2, '0'); //Месяц начинается с 0
        let year = today.getFullYear();
        document.querySelector('.date').value = year + '-' + month + '-' + day;
    }

    /**
     * Функция подсчёта позиций
     */
    static allSum()
    {
        let count = Array.from(document.querySelectorAll('.count')).map(inputElement => this.removeSpaces(inputElement.value));
        let price = Array.from(document.querySelectorAll('.price')).map(inputElement => this.microRuble(this.removeSpaces(inputElement.value)));
        let summa = document.querySelectorAll('.sumPrice');
        let nds = document.querySelectorAll('.selectNds');
        let summaNds = document.querySelectorAll('.sumNalog');
        let sumPosition = document.querySelectorAll('.sumPosition');

        for (let i = 0; i < count.length; i++) {
            summa[i].value = this.spaceDigits(this.remMicroRuble(count[i] * price[i]).toFixed(2));
            let result = count[i] * price[i];

            if (nds[i].value === 'decrease') {
                summaNds[i].value = this.spaceDigits(this.remMicroRuble(result * 20 / (20 + 100)).toFixed(2));
                sumPosition[i].value = this.spaceDigits(this.remMicroRuble(result).toFixed(2));
            } else if (nds[i].value === 'increase') {
                summaNds[i].value = this.spaceDigits(this.remMicroRuble((result * (20 + 100) / 100) - result).toFixed(2));
                sumPosition[i].value = this.spaceDigits(this.remMicroRuble((result * (20 + 100) / 100)).toFixed(2));
            } else {
                summaNds[i].value = 0;
                sumPosition[i].value = this.spaceDigits(this.remMicroRuble(result).toFixed(2));
            }
        }
        this.total();
    }



    /**
     * Сумма всех позиций колонка (Итого с НДС)
     */
    static total()
    {
        let totalTd = [
            '.totalSumCount',
            '.totalSumPrice',
            '.totalSumNds',
            '.sumCheck'
        ];

        let totalInput = [
            '.count',
            '.sumPrice',
            '.sumNalog',
            '.sumPosition'
        ];

        for (let i = 0; i < totalTd.length; i++) {
            this.sumPosition(totalTd[i], totalInput[i]);
        }
    }

    /**
     * Сумма всех позиций с пропуском некорректных данных
     */
    static sumPosition(totalTd, totalInput)
    {
        let sum = 0;
        let positions = document.querySelectorAll(totalInput);

        positions.forEach(item => {
            let value = this.removeSpaces(item.value);

            // Проверяем, что значение существует и является числом
            if (value && !isNaN(value)) {
                sum += parseFloat(value);
            }
        });

        let sumCheck = document.querySelector(totalTd);
        if (sumCheck) { // Проверяем, что элемент найден
            // Определяем, сколько знаков после запятой оставить
            let decimals = totalTd === '.totalSumCount' ? 3 : 2;
            sum = sum.toFixed(decimals);

            // Устанавливаем текст содержимого
            sumCheck.textContent = this.spaceDigits(sum) + (totalTd !== '.totalSumCount' ? ' руб' : '');
        }
    }


    /**
     * Получение данных о компании
     */
    static getDateCompany(id)
    {

        this.preLoad();

        fetch('/check/getDateCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id' : id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                // data возвращается id name
                document.getElementById('company').innerText = data.name;
                document.getElementById('company').dataset.id = data.id;
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Поиск по Инн компании
     */
    static searchCompany(id, inn)
    {

        let url = "http://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
        let token = "5ab8480580c1750bfa46f56c16f4c896a6673aa0";

        this.preLoad();

        let options = {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Token " + token
            },
            body: JSON.stringify({query: inn})
        }

        fetch(url, options)
            .then(response => response.text())
            .then(result => {
                try {
                    this.deletePreloader();
                    if (result && result !== '[]') { // Проверяем, что результат существует и не является пустым массивом в виде строки
                        let jsonObject = JSON.parse(result);

                        if (jsonObject.suggestions && jsonObject.suggestions.length > 0 && id === 'formAdd') {
                            document.getElementById('nameCompany').value = jsonObject.suggestions[0].value;
                            document.getElementById('kppCompany').value = jsonObject.suggestions[0].data.kpp;
                            document.getElementById('addressCompany').value = jsonObject.suggestions[0].data.address.unrestricted_value;
                        }

                        if (jsonObject.suggestions && jsonObject.suggestions.length > 0 && id === 'formEdit') {
                            document.getElementById('nameEditCompany').value = jsonObject.suggestions[0].value;
                            document.getElementById('kppEditCompany').value = jsonObject.suggestions[0].data.kpp;
                            document.getElementById('addressEditCompany').value = jsonObject.suggestions[0].data.address.unrestricted_value;
                        }
                    }
                } catch (error) {
                    this.deletePreloader();
                    this.modalShow('error');
                }
            })

    }

    /**
     * Поиск по бик банк
     */
    static searchBank(id, bic)
    {

        let url = "http://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/bank";
        let token = "5ab8480580c1750bfa46f56c16f4c896a6673aa0";

        this.preLoad();

        let options = {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Token " + token
            },
            body: JSON.stringify({query: bic})
        }

        fetch(url, options)
            .then(response => response.text())
            .then(result => {
                try {
                    this.deletePreloader();
                    if (result && result !== '[]') { // Проверяем, что результат существует и не является пустым массивом в виде строки
                        let jsonObject = JSON.parse(result);
                        if (jsonObject.suggestions && jsonObject.suggestions.length > 0 && id === 'formAdd') {
                            document.getElementById('nameBank').value = jsonObject.suggestions[0].value;
                            document.getElementById('corCheck').value = jsonObject.suggestions[0].data.correspondent_account;
                        }

                        if (jsonObject.suggestions && jsonObject.suggestions.length > 0 && id === 'formEdit') {
                            document.getElementById('bankEdit').value = jsonObject.suggestions[0].value;
                            document.getElementById('correspondentAccount').value = jsonObject.suggestions[0].data.correspondent_account;
                        }
                    }
                } catch (error) {
                    this.deletePreloader();
                    this.modalShow('error');
                }
            })
    }

    /**
     * Выбор всех позиций и удаление выбора
     */
    static setAllCheckbox()
    {
        const checkboxes = document.querySelectorAll('.checkbox');
        const allChecked = Array.from(checkboxes).every(item => item.checked);

        checkboxes.forEach(item => {
            item.checked = !allChecked;
        });
    }

    /**
     * Получение номера счета
     */
    static numberCheckUser()
    {
        this.preLoad();

        fetch('/check/numberCheckUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'value' : true,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                const input = document.getElementById('inputCheck');
                input.value = data.prefix+data.number;
                input.dataset.prefix = data.prefix;
                input.dataset.number = data.number;
                this.generateNumber();
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });

    }


    /**
     * Универсальная обработка значения
     */
    static processValue(value)
    {
        // Заменяем запятую на точку
        value = value.replace(',', '.');

        // Удаляем все символы, кроме цифр и точки
        value = value.replace(/[^0-9.]/g, '');

        // Если точек больше одной, оставляем только первую
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        return value;
    }

    /**
     * Замена меню при выставлении счета если выбрана хоть одна позиция
     */
    static addActionCheck()
    {
        const inputs = document.querySelectorAll('.checkbox');
        const input = document.getElementById('inputCheck');
        const blockSubmit = document.getElementById('blockSubmit');

        // Сохраняем изначальный номер счета в data-атрибуте, если он еще не сохранен
        if (!input.dataset.originalValue) {
            input.dataset.originalValue = input.value;
        }

        // Подсчитываем количество отмеченных чекбоксов
        const checkedCount = Array.from(inputs).filter(item => item.checked).length;

        if (checkedCount > 0) {
            // Восстанавливаем изначальный номер счета из data-атрибута
            input.value = input.dataset.originalValue;

            // Генерируем новый номер счета
            this.generateNumber();
        } else {
            // Восстанавливаем изначальное значение счета из data-атрибута
            input.value = input.dataset.originalValue;
        }
    }




    /**
     * Генератор номера счета
     */
    static generateNumber()
    {
        this.preLoad();

        fetch('/check/generateNumber', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'check': document.getElementById('inputCheck').value,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.getElementById('inputCheck').value = data;

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }


    static getDataCheck(id)
    {
        this.preLoad();

        fetch('/check/getDataCheck', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printCheckPosition(data);

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    static #printCheckPosition(data)
    {
        document.getElementById('company').innerText = data[0].companyName;
        document.getElementById('company').dataset.id = data[0].companyId;
        document.getElementById('inputCheck').value = data[0].number_check;
        document.getElementById('data_check').value = data[0].date_check;
        document.getElementById('comment').value = data[0].comment;

        const table = document.getElementById('formKanban');
        for (let i=0; i<data.length; i++) {
            let tr = document.createElement('tr');
            tr.classList.add('kanban__item');
            tr.innerHTML = `
                <td style="height: 34px">
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <input class="form-check-input checkbox " type="checkbox" value="" style="margin: 0;" data-action="checkbox">
                    </div>
                </td>
                <td><span class="form-control spanIndex">${i+1}</span></td>
                <td>
                    <input type="text" class="form-control form_group position" name="name" value="${data[i].positionName}">
                </td>
                <td>
                    <select class=" div3 form-select form_group position" name="unitOfMeasurement">
                        <option value="кг" ${(data[i].unit === 'кг') ? 'selected' : ''}>кг</option>
                        <option value="т" ${(data[i].unit === 'т') ? 'selected' : ''}>т</option>
                        <option value="метр" ${(data[i].unit === 'метр') ? 'selected' : ''}>метр</option>
                        <option value="м2" ${(data[i].unit === 'м2') ? 'selected' : ''}>м²</option>
                        <option value="м2" ${(data[i].unit === 'м3') ? 'selected' : ''}>м³</option>
                        <option value="шт" ${(data[i].unit === 'шт') ? 'selected' : ''}>шт</option>
                        <option value="литр" ${(data[i].unit === 'литр') ? 'selected' : ''}>литр</option>
                        <option value="упак" ${(data[i].unit === 'упак') ? 'selected' : ''}>упак</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form_group count position" name="count"  data-action="input" value="${data[i].count}">
                </td>
                <td>
                    <input type="text" class="form-control form_group price position" name="price"  data-action="input" value="${data[i].price}">
                </td>
                <td>
                    <input type="text" class="form-control form_group sumPrice position"  name="sumPrice" value="${data[i].sum}">
                </td>
                <td>
                    <select class="form-select form_group selectNds position" type="text" name="selectNds" data-action="selectNds" >
                        <option value="no" ${(data[i].nds === 'no') ? 'selected' : ''}>Без НДС</option>
                        <option value="decrease" ${(data[i].nds === 'decrease') ? 'selected' : ''}>Выдел.</option>
                        <option value="increase" ${(data[i].nds === 'increase') ? 'selected' : ''}>Начис.</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form_group sumNalog position"  name="sumNalog" value="${data[i].sum_nds}">
                </td>
                <td>
                    <input type="text" class="form-control form_group sumPosition position"  name="sumPosition" value="${data[i].result}">
                </td>
            </tr>
            `;
            // Найдем предпоследний элемент в форме
            let secondToLastElement = table.children[table.children.length -1];

// Вставляем новый элемент перед предпоследним
            table.insertBefore(tr, secondToLastElement);
        }

        this.allSum();
    }

}




export class Check extends Service {

    /**
     * Удаление компании поставщика
     */
    static deleteCompany()
    {
        this.preLoad();

        fetch('/check/deleteCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': document.getElementById('selectCompany').value,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                // Получаем элемент select по его id
                const selectElement = document.getElementById('selectCompany');
                selectElement.querySelectorAll('option').forEach(item=>{
                    if (item.value === data) {
                        item.remove();
                    }
                })

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод добавления компании поставщика
     */
    static addCompanyProvider()
    {

        // Получить элемент формы
        let form = document.getElementById('formAdd');

        // Создать новый объект FormData
        let formData = new FormData(form);

        // Преобразовать FormData в объект
        let formAdd = {};
        formData.forEach(function (value, key) {
            formAdd[key] = value;
        });

        this.preLoad();

        fetch('/check/addCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formAdd),
        }).then(response => response.json())
            .then(result => {
                this.deletePreloader(); // Вызов метода родителя
                this.offcanvasHide('offcanvasAdd');
                // Получаем элемент select по его id
                const selectElement = document.getElementById('selectCompany');

                // Создаем новый элемент option
                const newOption = document.createElement('option');
                newOption.text = result.name + ' ' + result.bank;
                newOption.value = result.id; // Опционально, можно задать значение для нового варианта

                // Добавляем новый элемент option в список вариантов выбора select
                selectElement.add(newOption);

                document.getElementById("formAdd").reset();
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Получение данных о компании поставщика
     */
    static getEditCompanyProvider()
    {
        const id = document.getElementById('selectCompany').value;
        this.preLoad();

        fetch('/check/getEditCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id' : id,
            }),
        }).then(response => response.json())
            .then(result => {
                this.deletePreloader(); // Вызов метода родителя
                this.offcanvasShow('offcanvasAdd');
                document.getElementById('nameEditCompany').value = result.company_name;
                document.getElementById('innEditCompany').value = result.inn_company;
                document.getElementById('kppEditCompany').value = result.kpp_company;
                document.getElementById('addressEditCompany').value = result.ur_address_company;
                document.getElementById('bankEdit').value = result.bank;
                document.getElementById('bikEditCompany').value = result.bik_bank_company;
                document.getElementById('correspondentAccount').value = result.kor_chet;
                document.getElementById('editAccountNumber').value = result.ras_chet;
                document.getElementById('formEdit').dataset.id = result.id;

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }


    static updateCompany()
    {
        // Получить элемент формы
        let form = document.getElementById('formEdit');

        // Создать новый объект FormData
        let formUpdate = new FormData(form);

        // Преобразовать FormData в объект
        let formEdit = {};
        formUpdate.forEach(function (value, key) {
            formEdit[key] = value;
        });
        formEdit['id'] = form.dataset.id;

        this.preLoad();

        fetch('/check/updateCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formEdit),
        }).then(response => response.json())
            .then(result => {
                this.deletePreloader(); // Вызов метода родителя
                this.offcanvasHide('offcanvasEdit');
                // Получаем элемент select по его id
                const selectElement = document.getElementById('selectCompany');
                const option = selectElement.querySelectorAll('option');

                option.forEach(item=>{
                    if (item.value === result.id) {
                        item.text = result.name + ' ' + result.bank;
                    }
                })

                document.getElementById("formEdit").reset();
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Функция добавления блока позиции
     */
    static addBlock()
    {
        let indexSp = this.indexPosition(document.querySelectorAll('.spanIndex'));
        let form = document.getElementById('formKanban');
        let block = document.createElement('tr');
        block.classList = 'kanban__item';
        block.innerHTML = `
                                    <td style="height: 34px">
                                        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                            <input class="form-check-input checkbox" type="checkbox" value="" style="margin: 0;" data-action="checkbox">
                                        </div>
                                    </td>
                                    <td><span class="form-control spanIndex">${indexSp}</span></td>
                                    <td>
                                        <input type="text" class="form-control form_group position" name="name">
                                    </td>
                                    <td>
                                        <select class=" div3 form-select form_group position" name="unitOfMeasurement">
                                            <option value="кг">кг</option>
                                                                    <option value="т">т</option>
                                                                    <option value="метр">метр</option>
                                                                    <option value="м2">м2</option>
                                                                    <option value="шт">шт</option>
                                                                    <option value="литр">литр</option>
                                                                    <option value="упак">упак</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form_group count position" name="count" value="0.00" data-action="input">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form_group price position" name="price" value="0.00" data-action="input">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form_group sumPrice position" value="0.00" name="sumPrice">
                                    </td>
                                    <td>
                                        <select class="form-select form_group selectNds position" type="text" name="selectNds">
                                            <option value="no">Без НДС</option>
                                            <option value="decrease" selected >Выдел.</option>
                                            <option value="increase">Начис.</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form_group sumNalog position" value="0.00" name="sumNalog">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form_group sumPosition position" value="0.00" name="sumPosition">
                                    </td>

        `;

        // Найдем предпоследний элемент в форме
        let secondToLastElement = form.children[form.children.length - 1];

        // Вставляем новый элемент перед предпоследним
        form.insertBefore(block, secondToLastElement);

    }


    static ajaxPosition()
    {
        const table = document.getElementById('formKanban');
        const rows = table.querySelectorAll('tr');

        let formData = {}; // Объект для хранения данных по строкам
        let hasChecked = false; // Флаг для проверки, есть ли выбранные строки

        rows.forEach((item, index) => {
            let checkbox = item.querySelector('td:first-child .checkbox');

            if (checkbox && checkbox.checked) {
                hasChecked = true; // Устанавливаем флаг, если хотя бы одна строка выбрана

                let position = checkbox.closest('tr');

                let inputs = Array.from(position.querySelectorAll('input'));
                let selects = Array.from(position.querySelectorAll('select'));

                // Инициализируем объект для текущей строки
                let rowData = {};

                inputs.forEach(input => {

                    if (input.name) {
                        rowData[input.name] = input.value; // Проверяем наличие имени
                    }
                });

                selects.forEach(select => {
                    if (select.name) {
                        rowData[select.name] = select.value; // Проверяем наличие имени
                    }
                });

                // Добавляем только строки с данными
                if (Object.keys(rowData).length > 0) {
                    formData[index] = rowData;
                }
                const get = this.getParam('id');
                const idCompany = (get) ? get : document.getElementById('company').dataset.id;

                formData.headers =  {
                    'id_company' : idCompany,
                    'number': document.getElementById('inputCheck').value,
                    'date': document.getElementById('data_check').value,
                    'companyProvider': document.getElementById('selectCompany').value,
                    'comment': document.getElementById('comment').value
                };
            }
        });

// Если ни одна строка не выбрана, собираем данные всех строк
        if (!hasChecked) {
            rows.forEach((item, index) => {
                let position = item;

                let inputs = Array.from(position.querySelectorAll('input'));
                let selects = Array.from(position.querySelectorAll('select'));

                // Инициализируем объект для текущей строки
                let rowData = {};

                inputs.forEach(input => {

                    if (input.name) {
                        rowData[input.name] = input.value; // Проверяем наличие имени
                    }
                });

                selects.forEach(select => {
                    if (select.name) {
                        rowData[select.name] = select.value; // Проверяем наличие имени
                    }
                });

                // Добавляем только строки с данными
            if (Object.keys(rowData).length > 0) {
                formData[index] = rowData;
                // Добавляем дополнительные данные


                //Вставить в обьект номер счета если старый
            }

                const get = this.getParam('id');
                const idCompany = (get) ? get : document.getElementById('company').dataset.id;

                formData.headers =  {
                    'id_company' : idCompany,
                    'number': document.getElementById('inputCheck').value,
                    'date': document.getElementById('data_check').value,
                    'companyProvider': document.getElementById('selectCompany').value,
                    'comment': document.getElementById('comment').value
                };
            });
        }

        const cleanNumericValues = (data) => {
            // Пройтись по всем ключам объекта
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const item = data[key];

                    // Пройтись по всем полям внутри вложенного объекта
                    for (const field in item) {
                        if (field === 'name' || field === 'comment') {
                            // Пропустить поле 'name'
                            continue;
                        }

                        if (item.hasOwnProperty(field) ) {
                            const value = item[field];

                            // Если значение является строкой и содержит цифры, удаляем пробелы
                            if (typeof value === 'string' && /\d/.test(value)) {
                                item[field] = value.replace(/\s/g, '');
                            }
                        }
                    }
                }
            }
            return data;
        };


        const cleanedData = cleanNumericValues(formData);


        this.preLoad();

        fetch('/check/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(cleanedData),
        }).then(response => response.json())
            .then(result => {
                this.deletePreloader(); // Вызов метода родителя
                // Получаем текущий URL
                const url = new URL(window.location.href);
                // Изменяем значение параметра "check"
                url.searchParams.set('check', result[0].id.new_id); // Заменяем на новое значение
                window.history.replaceState(null, '', url);
                this.generateNumber();
                window.location.href = '/check_total?check=' + result[0].id.new_id;
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }


}

/**
 * Класс вывода контекстного меню
 */
export class ContextMenu {
    constructor(menuSelector, taskItemClassName)
    {
        this.menu = document.querySelector(menuSelector);
        this.taskItemClassName = taskItemClassName;
        this.menuState = 0;
        this.activeClassName = "context-menu--active";


        this.init();
    }

    /**
     * Инициализация обработчиков событий
     */
    init()
    {
        this.contextListener();
        this.clickListener();
        this.keyupListener();
    }

    /**
     * Обработка события contextmenu (правая кнопка мыши)
     */
    contextListener()
    {
        document.addEventListener("contextmenu", (e) => {
            const targetElement = this.clickInsideElement(e, this.taskItemClassName);

            if (targetElement) {
                e.preventDefault();

                this.toggleMenuOn();
                this.positionMenu(e);
                // const element = targetElement.closest('tr');
                // element.classList.add('active');
            } else {
                this.toggleMenuOff();
            }
        });
    }

    /**
     * Обработка события click
     */
    clickListener()
    {
        document.addEventListener("click", (e) => {
            if (!this.clickInsideElement(e, this.activeClassName)) {
                this.toggleMenuOff();
            }
        });
    }

    /**
     * Обработка нажатия клавиш (Escape)
     */
    keyupListener()
    {
        window.addEventListener("keyup", (e) => {
            if (e.key === "Escape" || e.keyCode === 27) {
                this.toggleMenuOff();
            }
        });
    }

    /**
     * Включение контекстного меню
     */
    toggleMenuOn()
    {
        if (this.menuState !== 1) {
            this.menuState = 1;
            this.menu.classList.add(this.activeClassName);
        }
        // this.removeClass();
    }

    /**
     * Выключение контекстного меню
     */
    toggleMenuOff()
    {
        if (this.menuState !== 0) {
            this.menuState = 0;
            this.menu.classList.remove(this.activeClassName);
            this.clickedElement = null; // Сбрасываем сохранённый элемент
            // this.removeClass();
        }
         document.querySelector('input.plus').value = '';
         document.querySelector('input.minus').value = '';
    }

    // removeClass(){
    //     const table = document.getElementById('formKanban');
    //     let tr = table.querySelectorAll('tr');
    //     tr.forEach(item=>{
    //         item.classList.remove('active');
    //     })
    // }


    /**
     * Проверка клика внутри элемента с заданным классом
     */
    clickInsideElement(e, className)
    {
        let el = e.target;

        while (el) {
            if (el.classList && el.classList.contains(className)) {
                return el;
            }
            el = el.parentNode;
        }
        return null;
    }

    /**
     * Получение координат клика
     */
    getPosition(e)
    {
        let posx = 0, posy = 0;

        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        } else if (e.clientX || e.clientY) {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }

        return { x: posx, y: posy };
    }

    /**
     * Расположение контекстного меню
     */
    positionMenu(e)
    {
        const clickCoords = this.getPosition(e);
        const menuWidth = this.menu.offsetWidth;
        const menuHeight = this.menu.offsetHeight;
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;

        // Расчет горизонтального положения
        if ((windowWidth - clickCoords.x) < menuWidth) {
            this.menu.style.left = `${windowWidth - menuWidth}px`;
        } else {
            this.menu.style.left = `${clickCoords.x}px`;
        }

        // Расчет вертикального положения
        if ((windowHeight - clickCoords.y) < menuHeight) {
            this.menu.style.top = `${clickCoords.y - menuHeight}px`;
        } else {
            this.menu.style.top = `${clickCoords.y}px`;
        }
    }
}



export class PriceUpdater {
    constructor()
    {
        this.prise = [];
        this.arrayInput = [];
        this.table = document.getElementById('formKanban');
        this.up = document.querySelector('input.plus');
        this.down = document.querySelector('input.minus');

        // Привязываем обработчики
        this.bindEvents();
    }

    // Метод для обновления массива чекбоксов и цен
    updateInputArray()
    {
        this.arrayInput = []; // Сбрасываем массив
        this.prise = []; // Сбрасываем значения цен

        const rows = this.table.querySelectorAll('tr');

        rows.forEach(item => {
            let checkbox = item.querySelector('td:first-child .checkbox');

            if (checkbox && checkbox.checked) {
                let targetCell = item.querySelector('td:nth-child(6) input');
                if (targetCell) {
                    this.arrayInput.push(targetCell);
                    this.prise.push(Service.removeSpaces(targetCell.value));
                }
            }
        });

        // Если ничего не выбрано, берем все элементы из 6-й ячейки
        if (this.arrayInput.length === 0) {
            rows.forEach(item => {
                let targetCell = item.querySelector('td:nth-child(6) input');
                if (targetCell) {
                    this.arrayInput.push(targetCell);
                    this.prise.push(Service.removeSpaces(targetCell.value));
                }
            });
        }
    }

    // Метод для увеличения суммы на %
    handleIncrease()
    {
        let UpPrise = parseFloat(this.up.value.replace(/,/, '.')) || 0;

        let sum_prise = this.prise.map(num => {
            let multiplier = 1 + (UpPrise / 100);
            return Math.round(num * multiplier * 100) / 100;
        });

        sum_prise.forEach((value, index) => {
            this.arrayInput[index].value = Service.spaceDigits(value.toFixed(2));
        });

        Service.allSum();
    }

    // Метод для уменьшения стоимости на %
    handleDecrease()
    {
        let DownPrise = parseFloat(this.down.value.replace(/,/, '.')) || 0;

        let sum_prise = this.prise.map(num => {
            let discount = num * (DownPrise / 100);
            return Math.round((num - discount) * 100) / 100;
        });

        sum_prise.forEach((value, index) => {
            this.arrayInput[index].value = Service.spaceDigits(value.toFixed(2));
        });

        Service.allSum();
    }

    // Привязка обработчиков событий
    bindEvents()
    {
        // Обработчик для обновления массива при клике правой кнопкой
        document.addEventListener('contextmenu', () => this.updateInputArray());

        // Увеличение суммы на %
        this.up.addEventListener('input', () => this.handleIncrease());

        // Уменьшение стоимости на %
        this.down.addEventListener('input', () => this.handleDecrease());
    }
}

