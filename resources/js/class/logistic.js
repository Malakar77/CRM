import {UserService} from "../script.js";


export class LogisticModel extends UserService {

    /**
     * Метод для запроса всех категорий
     */
    static getCity()
    {
        this.preLoad(); // Вызов метода родителя
        fetch('logistic/getCategories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'add': true
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printCity(data);
            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод вывода экспедиторов
     * @param page
     * @param search
     */
    static getPosition(page = 1, search = 'all')
    {
        this.preLoad(); // Вызов метода родителя
        fetch('logistic/getLogistics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'page': page,
                'search': search
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printLogistics(data[1])
                document.querySelector('.paginatorNav').innerHTML = '';
                this.paginatorNav(data[0], data[2])
            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Функция вывода дополнительных данных о логисте
     * @param id
     */
    static getInfoLogistic(id)
    {
        this.preLoad();

        fetch('logistic/getInfoLogistics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printInfo(data);


            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Заполнение данных окна дополнительной информации
     * @param data json данные из базы
     */
    static #printInfo(data)
    {
        const name = document.getElementById('name');
        const phone = document.getElementById('number');
        const transport = document.getElementById('transportDetails');
        const dopInfoDetails = document.getElementById('dopInfoDetails');
        let star = '';
        for (let i = 0; i < data.statistic; i++) {
            star += `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" color="#ffd700">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            `;
        }

        name.innerHTML = data.name + ' ' + data.patronymic + ' ' + data.surname + ' ' + star;
        phone.innerHTML = data.phone ?? 'Отсутствует';
        transport.innerText = data.transport ?? 'Отсутствует';
        dopInfoDetails.innerText = data.info ?? 'Отсутствует';
    }

    /**
     * Метод добавления категорий
     * @param data
     */
    static #printCity(data)
    {
        let block = document.querySelector('.list-group');

        for (let i = 0; i < data.length; i++) {
            let categoriesList = document.createElement('a');

            categoriesList.classList = 'list-group-item list-group-item-action categories';
            categoriesList.dataset.action = 'categories';
            categoriesList.textContent = data[i];


            block.append(categoriesList);
        }
    }

    /**
     * Добавление активной ссылки
     * @param target
     */
    static addActive(target)
    {
        const elem = document.querySelectorAll('a.categories');
        elem.forEach(item => {
            item.classList.remove('active');
        });
        target.classList.add('active');
    }

    static getPassport(id)
    {
        this.preLoad();
        fetch('logistic/getPassportLogist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printPassport(data)

            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Заполнение формы данных для доверенности данными паспорта логиста
     * @param data
     */
    static #printPassport(data)
    {

        let document_type = document.querySelector('.document_type');
        let fio = document.querySelector('.fio');
        let seria = document.querySelector('.seria');
        let numberPassport = document.querySelector('.numberPassport');
        let given = document.querySelector('.given');
        let dateGiven = document.querySelector('.dateGiven');

        document_type.value = data.document_type;
        fio.value = data.surname + ' ' + data.name + ' ' + data.patronymic;
        seria.value = data.series;
        numberPassport.value = data.number;
        given.value = data.issued;
        dateGiven.value = data.date_issued;
    }

    /**
     * Метод получения данных о компаниях
     */
    static getCompany()
    {

        this.preLoad();

        fetch('logistic/getCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'company': true,
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                this.#printAddCompany(data);

            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
            });
    }

    /**
     * Вспомогательный метод заполнения Select данными
     * @param data
     */
    static #printAddCompany(data)
    {

        const select = $('#select')[0].selectize; // Получаем инстанс selectize
        const companyProvider = $('#companyProvider')[0].selectize; // Получаем инстанс selectize

        select.clearOptions();
        companyProvider.clearOptions();

        // Добавляем новые опции
        for (let i = 0; i < data.length; i++) {
            select.addOption({value: data[i].id, text: data[i].company_name});
            companyProvider.addOption({value: data[i].id, text: data[i].company_name});
        }
    }

    /**
     * Метод обработки формы добавления логиста
     */
    static formAdd()
    {

        const form = document.getElementById('formAdd');

        let formData = new FormData(form);

        let formAddLogisticObject = {};
        formData.forEach(function (value, key) {
            formAddLogisticObject[key] = value;
        });

        this.preLoad();

        fetch('logistic/addLogistic', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify(
                formAddLogisticObject
            )
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;  // Пробрасываем ошибки для обработки
                    });
                }
                return response.json();
            })
            .then(data => {
                this.deletePreloader();

                let inputAll = form.querySelectorAll('input');
                inputAll.forEach(item => {
                    item.value = '';
                })

                const block = document.getElementById('logistic_list');
                let tr = document.createElement('tr');
                tr.dataset.id = data.id;
                tr.innerHTML = `
                    <td>
                        ${data.surname + ' ' + data.name + ' ' + data.patronymic}
                    </td>
                    <td>
                        ${data.phone}
                    </td>
                    <td>
                        ${data.transport}
                    </td>
                    <td>
                        ${data.city}
                    </td>
                     <td class="desktop-icons" style="text-align: end;">
                        <i class="bi bi-list" data-action="detail" style="margin-right: 10px" data-bs-toggle="modal" data-bs-target="#exampleModal1"></i>
                        <i class="bi bi-person-fill-add" data-action="dovAdd" data-bs-toggle="modal" data-bs-target="#exampleModal2"></i>
                    </td>
                    <td class="mobile-buttons">
                        <span class=" d-flex justify-content-end gap-2">
                            <button data-action="detail" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Подробнее</button>
                            <button data-action="dovAdd" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2">Доверенность</button>
                        </span>
                    </td>
                `;

                block.append(tr);


                const categories = document.getElementById('catalog');
                const categoriesList = categories.querySelectorAll('a');
                const cityName = data.city; // Предположим, что result.city содержит название города

                let cityFound = false;

                categoriesList.forEach(item => {
                    if (item.innerHTML.trim() === cityName) {
                        cityFound = true;
                    }
                });

        if (!cityFound) {
            // Создаем новый элемент <a> с названием города
            const newCityLink = document.createElement('a');
            newCityLink.classList = 'list-group-item list-group-item-action categories';
            newCityLink.dataset.action = 'categories';
            newCityLink.innerHTML = cityName;

            // Добавляем новый элемент в список
            categories.appendChild(newCityLink);
        }

                document.querySelector('textarea.info').value = '';
                document.querySelector('.AddLogisticSubmit').disabled = true;
                this.modalHide('formModalAdd');
            })
            .catch(error => {
                this.deletePreloader();
                const blockError = document.getElementById('errorAdd');

                // Если есть общая ошибка (например, исключение из модели)
                if (error.error) {
                    blockError.style.color = 'red';
                    blockError.innerHTML = error.error;
                } else if (error.errors) {
                    // Если ошибки валидации
                    this.error(error.errors);
                }

                // Удаление прелоадера
                this.deletePreloader();
            });
    }


    /**
     *
     * Метод заполнения формы редактирования компании
     * @param id Компании которую нужно отредактировать
     *
     */
    static getCompanyInfo(id)
    {
        this.preLoad();
        fetch('logistic/getDataCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': id,
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('editmodalCompany')
                document.getElementById('exampleModal2').style.zIndex = '1';
                this.#setFormData(data);
            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     *
     * Дополнительный метод для заполнения формы
     * @param data объект возвращаемый база данных.
     *
     */
    static #setFormData(data)
    {
        document.getElementById('editCompanyForm').dataset.id = data[0].id;
        document.getElementById('nameCompanyEdit').value = data[0].company_name;
        document.getElementById('innCompanyEdit').value = data[0].inn_company;
        document.getElementById('kppCompanyEdit').value = data[0].kpp_company;
        document.getElementById('adCompanyEdit').value = data[0].ur_address_company;
        document.getElementById('urCompanyEdit').value = data[0].address_company;
        document.getElementById('rasChetEdit').value = data[0].ras_chet;
        document.getElementById('bikBankEdit').value = data[0].bik_bank_company;
        document.getElementById('bankEdit').value = data[0].bank;
        document.getElementById('korChetEdit').value = data[0].kor_chet;
    }


    /**
     * Метод обновления компании
     */
    static updateCompany()
    {

        const form = document.getElementById('editCompanyForm');

        let formData = new FormData(form);

        let formUpdate = {};
        formData.forEach(function (value, key) {
            formUpdate[key] = value;
        });

        formUpdate['id'] = document.getElementById('editCompanyForm').dataset.id;

        this.preLoad();

        fetch('logistic/updateCompany', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify(
                formUpdate
            )
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;  // Пробрасываем ошибки для обработки
                    });
                }
                return response.json();
            })
            .then(data => {
                this.deletePreloader();
                this.modalHide('editmodalCompany');
            })
            .catch(() => {

                // Удаление прелоадера
                this.deletePreloader();
            });
    }


    /**
     * Метод получения данных из Dadata по API
     * Поиск компании по ИНН
     */
    static searchApi()
    {

        const query = parseInt(document.getElementById('inputAddCompanyInn').value);

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
            body: JSON.stringify({query: query})
        }
        fetch(url, options)
            .then(response => response.json())
            .then(result => {
                this.deletePreloader();
                this.#printCompany(result)

            })
            .catch(error => {
                this.deletePreloader();
                console.log("error", error);
            });
    }

    /**
     * Метод получения данных из Dadata по API
     * Данные по БИК о банке
     */
    static searchBankApi()
    {
        this.preLoad();

        let url = "http://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/bank";
        let token = "5ab8480580c1750bfa46f56c16f4c896a6673aa0";
        const query = document.getElementById('bikBankCompany').value;

        let options = {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": "Token " + token
            },
            body: JSON.stringify({query: query})
        }

        fetch(url, options)
            .then(response => response.json())
            .then(result => {
                this.deletePreloader();
                this.#printBank(result)
            })
            .catch(error => {
                this.deletePreloader();
                console.log("error", error)
            });

    }

    /**
     * Вывод данных о компании после поиска по ИНН
     * @param data объект данных из DaData
     */
    static #printCompany(data)
    {
        document.getElementById('nameCompanySearch').value = data.suggestions[0].value;
        document.getElementById('innCompanySearch').value = data.suggestions[0].data.inn;
        document.getElementById('kppCompanySearch').value = data.suggestions[0].data.inn;
        document.getElementById('kppCompanySearch').value = data.suggestions[0].data.kpp;
        document.getElementById('adCompanySearch').value = data.suggestions[0].data.address.unrestricted_value;
        document.getElementById('urCompanySearch').value = data.suggestions[0].data.address.unrestricted_value;
    }

    /**
     * Вспомогательный метод заполнения данными формы о банке
     * @param data объект данных из DaData
     */
    static #printBank(data)
    {
        document.getElementById('bank').value = data.suggestions[0].value;
        document.getElementById('korChet').value = data.suggestions[0].data.correspondent_account   ;
    }

    /**
     * Метод запроса и вывода всех доверенностей со статусом True
     */
    static getAttorneyUser()
    {
        this.preLoad();

        fetch('logistic/getAttorneyUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                true
            )
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printAttorney(data);

            }).catch(() => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Вспомогательный метод для вывода доверенностей
     * в таблицу
     * @param data json объектов со всеми данными доверенностей.
     */
    static #printAttorney(data)
    {
        const tBody = document.getElementById('archive');
        tBody.innerHTML = '';
        for (let i =0; i<data.length; i++) {
            let tr = document.createElement('tr');
            tr.dataset.id = data[i].id;

            let date = (data[i].date) ? this.formatDate(data[i].date) : '';
            tr.innerHTML = `
                <td scope="row" >${i+1}</td>
                    <td data-action="pageAttorney">${data[i].name.substring(0, 11) + "..." ?? ''}</td>
                    <td data-action="pageAttorney">${date['full'] ?? ''}</td>
                    <td data-action="pageAttorney">
                        <i class="bi bi-trash" data-action="trash"></i>
                    </td>
            `;
            tBody.append(tr);
        }
    }

    /**
     *
     * Метод добавления кнопки редактирования компания
     * при наличии выбранной компании
     * @param select блок select для которого выбрана компания
     * @param block блок куда добавляется кнопка
     * @param text текст кнопки для вывода.
     *
     */
    static addIconEditButton(select, block, text)
    {

        let selectedValue = select.getValue();

        if (selectedValue) {
            block.innerHTML = `${text} <i class="bi bi-pen pen" data-action="pen"></i>`;
        } else {
            block.innerHTML = text;
        }
    }

    /**
     * Метод удаления доверенности
     * @param elem элемент по которому произошел клик
     */
    static deleteAttorney(elem)
    {

        const tr = elem.target.closest('tr');

        this.preLoad();
        fetch('logistic/deleteAttorneyUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id': tr.dataset.id,
            }),
        }).then(response => response.json())
            .then(data => {
                console.log(typeof data)
                this.deletePreloader(); // Вызов метода родителя

                tr.remove();
                const tbody = document.getElementById('archive');
                let trAll = tbody.querySelectorAll('tr');
                let i = 1;
                trAll.forEach(item=>{
                    item.children[0].innerHTML = i;
                    i++;
                });

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    static addDov()
    {
        const form = document.getElementById('dov');

        let formData = new FormData(form);

        let formAddDover = {};
        formData.forEach(function (value, key) {
            formAddDover[key] = value;
        });


        if (formAddDover.nameLogist  !== '') {
            formAddDover['idLogist'] = form.dataset.id;
        } else {
            formAddDover['idLogist'] = null;
        }


        this.preLoad();

        fetch('logistic/addDover', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                formAddDover
            )
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalHide('exampleModal2');
                window.location.href = `/attorney?id=${data.attorney_id}`;
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }





    /**
     * Метод вывода HTML разметки экспедиторов
     * @param data
     */
    static #printLogistics(data)
    {
        const table = document.querySelector('tbody');
        table.innerHTML = "";
        for (let i = 0; i<data.length; i++) {
            let star = ' ';

            for (let j = 0; j < data[i].statistic; j++) {
                star += `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" style="color: gold;">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                `;
            }

            let tr = document.createElement('tr');
            tr.dataset.id = data[i].id;
            tr.innerHTML = `
                    <td>
                        ${data[i].surname + ' ' + data[i].name + ' ' + data[i].patronymic + ' ' + star}
                    </td>
                    <td>
                        ${data[i].phone}
                    </td>
                    <td>
                        ${data[i].transport.substring(0, 50) + "..."}
                    </td>
                    <td>
                        ${data[i].city}
                    </td>
                     <td class="desktop-icons" style="text-align: end;" >
                        <i class="bi bi-list" data-action="detail" style="margin-right: 10px" data-bs-toggle="modal" data-bs-target="#exampleModal1"></i>
                        <i class="bi bi-person-fill-add" data-action="dovAdd" data-bs-toggle="modal" data-bs-target="#exampleModal2"></i>
                    </td>
                    <td class="mobile-buttons">
                        <span class=" d-flex justify-content-end gap-2">
                            <button data-action="detail" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1">Подробнее</button>
                            <button data-action="dovAdd" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2">Доверенность</button>
                        </span>
                    </td>
                `;
            table.append(tr);
        }
    }



    /**
     * Приватный метод обработки ошибок при добавлении логиста
     * @param errors
     */
    static #error(errors)
    {
        const form = document.getElementById('formAdd');
        let inputs = form.querySelectorAll('input');

        inputs.forEach(item => {
            let fieldName = item.getAttribute('name'); // Получаем имя поля из атрибута name
            if (errors.hasOwnProperty(fieldName)) { // Проверяем есть ли ошибка для этого поля
                item.nextElementSibling.innerHTML = errors[fieldName][0]; // Выводим первую ошибку
                item.classList.add('emptyInput');
                item.nextElementSibling.style.color = 'red';
            } else {
                // Если ошибки нет, убираем стили для корректных полей
                item.classList.remove('emptyInput');

                if (item.classList.contains('phone')) {
                    item.nextElementSibling.innerHTML = 'Не более 20 символов';
                } else {
                    item.nextElementSibling.innerHTML = 'Не более 50 символов';
                }
            }
        });
    }

    /**
     * Удаление активной категории
     */
    static clearActive()
    {
        const tegA = document.querySelectorAll('a.categories');
        tegA.forEach(item=>{
            item.classList.remove('active');
        })
    }

    /**
     * Добавление компании
     */
    static addCompany()
    {

        const form = document.getElementById('searchInn');

        let formData = new FormData(form);

        let formAddCompany = {};
        formData.forEach(function (value, key) {
            formAddCompany[key] = value;
        });

        formAddCompany['status'] = 'dover';

        this.preLoad();

        fetch('Attorney/addCompany', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify(
                formAddCompany
            )
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;  // Пробрасываем ошибки для обработки
                    });
                }
                return response.json();
            })
            .then(data => {
                this.deletePreloader();

                document.querySelector('.errorBlock').innerText = '';

                const select = $('#select')[0].selectize; // Получаем инстанс selectize
                const companyProvider = $('#companyProvider')[0].selectize; // Получаем инстанс selectize
                // Добавляем новые опции
                select.addOption({value: data.id, text: data.name});
                companyProvider.addOption({value: data.id, text: data.name});
                // Установить значение по умолчанию
                select.setValue(data.id);
                // companyProvider.setValue(data.id);

                this.#clearInputs();

                this.modalHide('addProvider');
            })
            .catch(error => {
                this.#error('searchInn');
                document.querySelector('.errorBlock').innerText = error;
                document.querySelector('.errorBlock').style.color = 'red';
                // Удаление прелоадера
                this.deletePreloader();
            });
    }

    /**
     * Очистка формы добавления компании
     */
    static #clearInputs()
    {
        const form = document.getElementById('searchInn');
        const inputs = form.querySelectorAll('input');
        inputs.forEach(item=>{
            item.value = '';
        })
    }

}
