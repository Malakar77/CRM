import {CompanyAdmin, CompanyService} from "./class/company/CompanyAdmin.js";

document.addEventListener('DOMContentLoaded', (e)=>{

    //Вывод списка выгрузки
    CompanyAdmin.unload();

    //вывод списка компаний
    CompanyAdmin.writeCompany();

    // Проверяем состояние кнопки при загрузке страницы
    CompanyService.disableBut();

    new clickController(document.querySelector('body'), CompanyService, CompanyAdmin);
    new changeController(document.querySelector('body'), CompanyService, CompanyAdmin)
    new keyDownController(document.querySelector('body'), CompanyService, CompanyAdmin)

})

class clickController {
    constructor(elem, service, company) {
        this.service = service;
        this.company = company;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Метод назначения менеджера
     */
    setManager(){
        this.company.editCompany()
    }

    /**
     * Удаление компании или массива компаний
     */
    delete(){
        this.company.deleteCompany ();
    }

    /**
     * Заполнение данными select
     * @param elem
     */
    addManager(elem){
        this.service.modalShow('selectManagerModal');
        this.company.addManager ();
    }

    /**
     * выбор активной выгрузки
     * вывод компаний из этой выгрузки
     * @param elem
     */
    active(elem){
        document.querySelector('.searchCompany').value = '';
        this.company.removeActive();
        this.company.addActive(elem);
        let tr = elem.target.closest('tr');
        this.company.writeCompany(tr.children[0].innerHTML, 1, 'new');
    }

    /**
     * Добавление компаний из файла
     */
    saveCompany(){
        if(this.service.validateFormFile()){
            this.company.sentFile();
        }
    }

    /**
     * выбор компании по клику на TS
     * @param elem
     */
    tdCheck(elem){
        this.service.clickChecked(elem);
        this.service.disableBut();
    }

    /**
     * Пагинация страницы без заданных значений поиска
     * @param elem кнопка пагинации
     */
    pageLink(elem){
        const href = parseInt(elem.target.dataset.href);
        const search = document.querySelector('.searchCompany').value;
        const table = document.querySelector('.exportList');
        const tr = table.querySelectorAll('.active');
        let active = '';
        tr.forEach(item=>{
            if(item.classList.contains('active')){
                active = item.children[0].innerHTML;
            }
        })

        if (search.trim() !== ''){
            this.company.writeCompany(search.trim(), href);
        }else if(active.trim() !== ''){
            this.company.writeCompany(active, href, 'new');
        }else{
            this.company.writeCompany('all', href);
        }

    }

    /**
     * Открытие модельного окна загрузки компаний
     */
    addCompany(){
        this.service.modalShow('exampleModal');
    }

    /**
     * Выбор всех компаний
     * @param elem
     */
    selected(elem){
        this.service.checked(elem);
    }

    /**
     * Метод обработки клика
     * @param event
     */
    onClick(event) {
        let action = event.target.dataset.action;
        if (action && typeof this[action] === 'function') {
            this[action](event);
        }
    }

}

class changeController {
    constructor(elem, service , companyModel) {
        this.service    = service;
        this.model    = companyModel;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * блокировка кнопок при отсутствии выбранных компаний
     */
    checkInput(){
        this.service.disableBut();
    }

    /**
     * Поиск
     * @param elem
     */
    search(elem){
        this.model.removeActive();
        let value = elem.target.value.trim();
        if(value !== ''){
            this.model.writeCompany(value, 1)
        }else{
            this.model.writeCompany('all', 1);
        }
    }

    onChange(event) {
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
    constructor(elem, service , companyModel) {
        this.service    = service;
        this.model    = companyModel;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }

    /**
     * обработчик нажатия enter
     * @param elem
     */
    enter(elem){
        this.model.removeActive();
        let value = elem.target.value.trim();
        if(value !== ''){
            this.model.writeCompany(value, 1)
        }else{
            this.model.writeCompany('all', 1);
        }
    }

    /**
     * Обработчик события нажатия клавиш
     */
    keyDown(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            let action = event.target.dataset.enter;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}

const block = document.querySelector('.tableExport');
document.addEventListener('click', (e)=>{

    if(e.target.closest('.blockDatails') || e.target.closest('.modalManager')){
        return;
    }

    if (!block.contains(e.target)) {
        searchActive();
    }

})

function searchActive(){
    let table = document.querySelector('.tableExport');

    let active = table.querySelector('.active');
    if(active){
        CompanyAdmin.removeActive();
        CompanyAdmin.writeCompany();
    }else{
        return false;
    }
}



