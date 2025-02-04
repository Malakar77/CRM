
import {ViewProvider} from "./class/ProviderClass.js";
import {UserService} from "./script.js";
import {Check, ContextMenu, Service} from "./class/check.js";

document.addEventListener('DOMContentLoaded', function () {
    ViewProvider.viewPosition();
    ViewProvider.viewCompany();
    new clickController(document.querySelector('body'), ViewProvider);

})

class clickController {
    constructor(elem, service)
    {
        this.service = service;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Рендер формы добавление поставщика
     */
    add()
    {
        this.service.formAdd();
    }

    /**
     * Добавления поставщика
     */
    addProvider()
    {
        this.service.addProvider();
    }

    /**
     * Подготовка модельного окна удаления
     * @param elem
     */
    trash(elem)
    {
        const tr = elem.target.closest('tr');
        const id = tr.dataset.id;

        const modal = document.getElementById('delete');

        const title = modal.querySelector('.modal-body');
        title.innerText = `Вы действительно хотите удалить компанию ${tr.children[0].innerText}? `

        const button = modal.querySelector('.delete');
        button.dataset.id = id;

        this.service.modalShow('delete');
    }

    /**
     * Удаление компании
     * @param elem
     */
    delete(elem)
    {
        this.service.delete(elem.target);
    }

    /**
     * Заполнение формы редактирования поставщика
     * @param elem
     */
    getProvider(elem)
    {
        const tr = elem.target.closest('tr');
        const id = tr.dataset.id;
        this.service.getProvider(id);
    }

    /**
     * Отправка формы редактирования
     */
    editProvider()
    {
        this.service.editProvider()
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



document.addEventListener('click', (e)=>{

    /**
     * обработчик событий на перелистывание страниц
     */
    if (e.target.classList.contains('page-link')) {
        let active = ViewProvider.searchActive();
        let searchValue = document.querySelector("input.search").value.trim();
        let page = parseInt(e.target.dataset.href);

        if (searchValue !== '') {
            ViewProvider.searchCompany(searchValue, page);
        } else {
            if (active) {
                ViewProvider.searchCompany(active.innerHTML, page);
            } else {
                ViewProvider.viewCompany(page);
            }
        }
    }

    /**
     * Добавление класса активной ссылке
     */
    if (e.target.classList.contains('categories')) {
        document.querySelector("input.search").value = ' ';
            ViewProvider.addActive(e.target);
            ViewProvider.searchCompany(e.target.innerHTML);
    }

})

document.addEventListener('change', (e)=>{

    if (e.target.classList.contains('search')) {
        let elemValue = e.target.value;
            e.target.value = elemValue.trim();
            ViewProvider.clearActive();
            ViewProvider.searchCompany(elemValue);
    }

})

document.querySelector('input.search').addEventListener('keydown', (e)=> {

    // Проверяем, что была нажата клавиша Enter
    if (e.key === 'Enter') {
        e.preventDefault();
        let elemValue = e.target.value;
        ViewProvider.clearActive();
        ViewProvider.searchCompany(elemValue);
    }
});



