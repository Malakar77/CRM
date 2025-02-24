/* @lang java-script */
import { UserService } from "../script.js";

export class ManagerModel extends UserService{

    /**
     * Метод добавления компаний в форму добавления
     */
    static searchCompanyProvider(select)
    {
        this.preLoad();
        fetch('manager/getCompanyProvider', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'company': true,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#printCompany(data, select)
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }


    /**
     * Метод добавления менеджера
    */
    static addManager()
    {

        const form = document.getElementById('add');

        let formData = new FormData(form);

        let formAdd = {};
        formData.forEach(function (value, key) {
            formAdd[key] = value;
        });

        this.preLoad();

        fetch('manager/addManager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formAdd),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.#addManagersContact(data)
                this.modalHide('addManager');
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод заполнения формы редактирования
     * @param elem
     */
    static fillFormEdit(elem)
    {
        const tr = elem.closest('tr');
        let name = document.getElementById('editNameManager');
        let phone = document.getElementById('editPhone');
        let email = document.getElementById('editEmail');
        document.getElementById('edit').dataset.id = tr.dataset.id;

        document.querySelector('.nameCompany').innerHTML = tr.childNodes[1].innerText;
        name.value = tr.childNodes[3].innerText;
        phone.value = tr.childNodes[5].innerText;
        email.value = tr.childNodes[7].innerText;
    }

    /**
     * Метод редактирования менеджера
     * @param elem
     */
    static editForm(elem)
    {
        const form = document.getElementById('edit');

        let formData = new FormData(form);

        let formAdd = {};
        formData.forEach(function (value, key) {
            formAdd[key] = value;
        });

        formAdd['id'] = document.getElementById('edit').dataset.id;

        this.preLoad();

        fetch('manager/editManager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formAdd),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalHide('editManager');
                this.#editManager(document.getElementById('edit').dataset.id,  data)
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод вывода менеджеров поставщика
     * @param search
     * @param page
     */
    static printManager(search = 'all', page = 1)
    {

        this.preLoad();

        fetch('manager/printManager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'search': search,
                'page': page
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.querySelector('tbody').innerHTML = '';
                this.#addManagersContact(data[1])
                document.querySelector('.paginatorNav').innerHTML = '';
                this.paginatorNav(data[0], data[2])
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод удаления менеджера
     * @param id id записи
     * @param elem элемент по которому произошел клик
     */
    static deleteManager(id, elem)
    {
        this.preLoad();

        fetch('manager/deleteManager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id' : id
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                elem.closest('tr').remove();

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод очистки активных элементов по клику на пустую область
     */
    static clear()
    {
        const tr = document.querySelectorAll('tr');
        tr.forEach(item=>{
            item.classList.remove('activeTr');
        })
    }

    /**
     * Вспомогательный метод редактирования менеджера
     * @param id
     * @param data
     */
    static #editManager(id,  data)
    {
        const tr = document.querySelectorAll('tr');
        tr.forEach(item=>{
            let idTr = item.dataset.id;
            if (idTr === id) {
                item.children[1].innerHTML = data.name;
                item.children[2].innerHTML = `<a href="phone:${data.phone}" >${data.phone}</a>`;
                item.children[3].innerHTML = `<a href="mailto:${data.email}">${data.email}</a>`;
            }
        })
    }

    /**
     * Вспомогательный метод добавления менеджера
     */
    static #addManagersContact(data)
    {
        const tbody = document.querySelector('tbody');

        for (let i = 0; i < data.length; i++) {
            let tr = document.createElement('tr');

            tr.dataset.id = data[i].id;
            tr.innerHTML = `
            <td data-action="activeTd">${data[i].name}</td>
            <td data-action="activeTd">${data[i].name_manager}</td>
            <td data-action="activeTd"><a href="phone:${data[i].phone}" >${data[i].phone}</a></td>
            <td data-action="activeTd"><a href="mailto:${data[i].email}">${data[i].email}</a></td>
            <td class="desktop-icons" style="text-align: end;" data-action="activeTd">
                <i class="bi bi-pencil" data-action="edit" style="margin-right: 10px"></i>
                <i class="bi bi-trash" data-action="trash"></i>
            </td>
            <td class="mobile-buttons">
                <span class=" d-flex justify-content-end gap-2">
                    <button data-action="edit" class="btn btn-primary btn-sm">Редактировать</button>
                    <button data-action="trash" class="btn btn-danger btn-sm">Удалить</button>
                </span>
            </td>
            `;
            tbody.append(tr);
        }
    }

    /**
     * Выделение активного элемента
     * @param elem
     */
    static activeTr(elem)
    {
        const tr = document.querySelectorAll('tr');
        tr.forEach(item=>{
            item.classList.remove('activeTr');
        })
        let active = elem.target.closest('tr');
        active.classList.add('activeTr');
    }

    /**
     * Вспомогательный метод добавления компаний в форму
     * @param data
     * @param select
     */
    static #printCompany(data, select)
    {

        const companyProvider = $(select)[0].selectize; // Получаем инстанс selectize
        companyProvider.clearOptions();

        for (let i = 0; i < data.length; i++) {
            companyProvider.addOption({value: data[i].id, text: data[i].name});
        }
    }



}
