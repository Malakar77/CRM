import { UserService } from "../script.js";

export class ViewProvider extends UserService {

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

    /**
     * Поиск активной ссылки
     * @returns {Element|boolean}
     */
    static searchActive()
    {
        const tegA = document.querySelectorAll('a.categories');

        for (let item of tegA) {
            if (item.classList.contains('active')) {
                return item;  // Если нашли активный элемент, возвращаем его
            }
        }

        return false;  // Если ни один элемент не активен, возвращаем false
    }

    /**
     * Метод поиска компаний по ссылке
     * @param target
     * @param page
     */
    static searchCompany(target, page = 1)
    {
        this.preLoad(); // Вызов метода родителя (UserService)
        fetch('provider/searchCompany', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify({
                'page': page,
                'search' : target
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printProvAll(data)
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод для запроса всех категорий
     */
    static viewCompany(page = 1)
    {
        this.preLoad(); // Вызов метода родителя
        fetch('provider/getCompany', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify({
                'page': page
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printProvAll(data)
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод для запроса всех категорий
     */
    static viewPosition()
    {
        this.preLoad(); // Вызов метода родителя
        fetch('provider/ProviderController', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printCategories(data);
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод вывода компаний
     * @param data
     */
    static #printProvAll(data)
    {
        document.querySelector('tbody').innerHTML = '';
        const provider = data[1];
        const table = document.querySelector('tbody');
        for (let i = 0; i < provider.length; i++) {
            let tr = document.createElement('tr');
            tr.dataset.id = provider[i].id;
            tr.innerHTML = `
                <td>${provider[i].name}</td>
                <td>${provider[i].phone}</td>
                <td><a href="https://${provider[i].link}" rel="noopener noreferrer" target="_blank">${provider[i].link}</a></td>
                <td>${provider[i].city}</td>
                <td class="desktop-icons" style="text-align: end;">
                        <i class="bi bi-pencil" data-action="getProvider" style="margin-right: 10px"></i>
                        <i class="bi bi-trash" data-action="trash"></i>

                    </td>
                <td class="mobile-buttons">
                    <span class="mobile-buttons-span d-flex justify-content-end gap-2">
                        <button data-action="getProvider" class="btn btn-primary btn-sm">Редактировать</button>
                        <button data-action="trash" class="btn btn-danger btn-sm">Удалить</button>
                    </span>
                </td>
            `;
            table.append(tr);
        }
        document.querySelector('.paginatorNav').innerHTML = '';
        this.paginatorNav(data[0], data[2]); // Вызов метода родителя
    }

    /**
     * Метод добавления категорий
     * @param data
     */
    static #printCategories(data)
    {
        let block = document.querySelector('.list-group');

        for (let i = 0; i < data.length; i++) {
            let categoriesList = document.createElement('a');

            categoriesList.classList = 'list-group-item list-group-item-action categories';
            categoriesList.textContent = data[i].catalog;

            block.append(categoriesList);
        }
    }

    /**
     * Метод добавления категорий в модельное окно
     * @param data
     */
    static #getCategories(data)
    {
        let block = document.querySelector('#select');

        for (let i = 0; i < data.length; i++) {
            let option = document.createElement('option');

            option.dataset.value = data[i].catalogList;
            option.textContent = data[i].catalog;

            block.append(option);
        }
    }

    static #validateForm(inputs)
    {
        let form = {};
        let hasError = false;

        for (const key in inputs) {
            const input = inputs[key];
            const value = input.value.trim();
            const maxLength = key === 'phone' ? 15 : 50;

            form[key] = value; // Сохраняем значение в форму

            if (value === '' || value.length > maxLength) {
                input.classList.add('error');
                hasError = true; // Устанавливаем флаг ошибки
            } else {
                input.classList.remove('error');
            }
        }

        if (hasError) {
            return false;
        } else {
            return form;
        }
    }


    /**
     * Метод добавления поставщиков
     */
    static addProvider()
    {
        const inputs = {
            name: document.getElementById('name'),
            categories: document.getElementById('categories'),
            phone: document.getElementById('phone'),
            website: document.getElementById('website'),
            city: document.getElementById('city'),
        };

        const form = this.#validateForm(inputs);

        if (form) {
            this.preLoad();
            fetch('provider/addProvider', {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method: 'POST',
                body: JSON.stringify(
                    form
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

                    for (let inputsKey in inputs) {
                        inputs[inputsKey].value = '';
                    }

                    const table = document.getElementById('providers');
                    let provider = document.createElement('tr');
                    provider.dataset.id = data.id;
                    provider.innerHTML = `
                    <td>${data.name}</td>
                    <td>${data.phone}</td>
                    <td>${data.website}</td>
                    <td>${data.city}</td>
                    <td class="desktop-icons" style="text-align: end;">
                        <i class="bi bi-pencil" data-action="getProvider" style="margin-right: 10px"></i>
                        <i class="bi bi-trash" data-action="trash"></i>
                    </td>
                    <td class="mobile-buttons">
                        <span class=" d-flex justify-content-end gap-2">
                            <button data-action="getProvider" class="btn btn-primary btn-sm">Редактировать</button>
                            <button data-action="trash" class="btn btn-danger btn-sm">Удалить</button>
                        </span>
                    </td>
                    `;
                    table.append(provider);

                    const categories = document.querySelectorAll('.categories');
                    const Categories = Array.from(categories).filter(category => category.innerText.trim() === data.categories);
                    if (Categories.length === 0) {
                        let block = document.querySelector('.list-group');
                        const link = document.createElement('a');
                        link.classList = 'list-group-item list-group-item-action categories';
                        link.innerText = data.categories;
                        block.append(link);
                    }

                    this.modalHide('formModalAdd');
                })
                .catch(error => {
                    this.deletePreloader();
                    this.modalShow('error')
                });
        }
    }


    static delete(elem)
    {
        const id = elem.dataset.id;

        this.preLoad();
        fetch('provider/delete', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify({
                'id': id,
            })
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
                this.modalHide('delete');
                document.querySelectorAll('tr').forEach(item=>{
                    if ( item.dataset.id === id ) {
                        item.remove();
                    }
                })
            })
            .catch(error => {
                this.deletePreloader();
                this.modalShow('error')
            });
    }

    /**
     * Заполнение формы добавления поставщика
     */
    static formAdd()
    {
        const modal = document.getElementById('formModalAdd');
        const body = modal.querySelector('.modal-body');
        body.innerHTML = '';
        const footer = modal.querySelector('.modal-footer');

        let form = document.createElement('form');
        form.id = 'AddFormProvider';
        form.innerHTML = `
                    <div class="mb-3">
                        <label for ="exampleFormControlInput1" class="form-label">Название компании</label>
                        <input type="text" class="form-control name" id="name" placeholder="Название компании" name="name">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="categories" class="form-label">Категория</label>
                        <input class="form-control inputDataList" list="select" id="categories" placeholder="Введите для поиска..." name="categorize">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                        <datalist id="select" class="datalist">
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for ="phone" class="form-label">Телефон</label>
                        <input type="text" class="form-control phone" id="phone" placeholder="+7 999 999 99 99" name="phone">
                        <div id="emailHelp" class="form-text">Не более 15 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="website" class="form-label">Сайт</label>
                        <input type="email" class="form-control sait" id="website" placeholder="www.exemple.com" name="link">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="city" class="form-label">Город</label>
                        <input type="text" class="form-control city" id="city" placeholder="Москва" name="city">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
        `;
        body.append(form);

        footer.innerHTML = `
            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-primary glow-on-hover" data-action="addProvider" style="position: relative;">Сохранить</button>
        `;

        this.preLoad(); // Вызов метода родителя
        fetch('provider/ProviderController', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#getCategories(data);
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
        this.modalShow('formModalAdd');
    }

    /**
     * Заполнение формы редактирования поставщика
     * @param id
     */
    static getProvider(id)
    {
        console.log(1)
        this.preLoad(); // Вызов метода родителя

        fetch('provider/getProvider', {
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

                const modal = document.getElementById('formModalAdd');

                const body = modal.querySelector('.modal-body');
                body.innerHTML = '';
                let form = document.createElement('form');
                form.id = 'EditFormProvider';
                form.dataset.id = data['provider'].id;
                form.innerHTML = `
                    <div class="mb-3">
                        <label for ="name" class="form-label">Название компании</label>
                        <input type="text" class="form-control name" id="name" placeholder="Название компании" name="name" value="${data['provider'].name}">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="categories" class="form-label">Категория</label>
                        <input class="form-control inputDataList" list="select" id="categories" placeholder="Введите для поиска..." value="${data['provider'].catalog}">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                        <datalist id="select" class="datalist">
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for ="phone" class="form-label">Телефон</label>
                        <input type="text" class="form-control phone" id="phone" placeholder="+7 999 999 99 99" value="${data['provider'].phone}">
                        <div id="emailHelp" class="form-text">Не более 15 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="website" class="form-label">Сайт</label>
                        <input type="email" class="form-control sait" id="website" placeholder="www.exemple.com" value="${data['provider'].link}">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                    <div class="mb-3">
                        <label for ="city" class="form-label">Город</label>
                        <input type="text" class="form-control city" id="city" placeholder="Москва" value="${data['provider'].city}">
                        <div id="emailHelp" class="form-text">Не более 50 символов</div>
                    </div>
                `;
                body.append(form);

                const footer = modal.querySelector('.modal-footer');
                footer.innerHTML = `
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary glow-on-hover" data-action="editProvider" style="position: relative;">Сохранить</button>
                `;

                this.#getCategories(data['categories']);
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
        this.modalShow('formModalAdd');
    }

    /**
     * Редактирование поставщика
     */
    static editProvider()
    {
        const inputs = {
            name: document.getElementById('name'),
            categories: document.getElementById('categories'),
            phone: document.getElementById('phone'),
            website: document.getElementById('website'),
            city: document.getElementById('city'),
        };

        const form = this.#validateForm(inputs);
        form['id'] = document.getElementById('EditFormProvider').dataset.id;
        this.preLoad();
        fetch('provider/update', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'POST',
            body: JSON.stringify(
                form
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
                    const table = document.getElementById('providers');
                    const allTr = table.querySelectorAll('tr');
                    allTr.forEach(item=>{
                        if (item.dataset.id === data.id) {
                            console.log(data.name)
                            item.children[0].innerText = data.name;
                            item.children[1].innerText = data.phone;
                            item.children[2].innerHTML = `<a href="https://${data.website}" rel="noopener noreferrer" target="_blank">${data.website}</a>`;
                            item.children[3].innerText = data.city;
                        }
                    })

                const categories = document.querySelectorAll('.categories');
                const Categories = Array.from(categories).filter(category => category.innerText.trim() === data.categories);
                if (Categories.length === 0) {
                    const catalog = document.getElementById('catalog');
                    const a = document.createElement('a')
                    a.classList = 'list-group-item list-group-item-action categories';
                    a.innerText = data.categories;
                    catalog.append(a);
                }

                this.modalHide('formModalAdd');
            })
            .catch(error => {
                this.deletePreloader();
                this.modalShow('error')
            });
    }

}
