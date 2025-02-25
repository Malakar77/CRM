import {LogisticModel, Archive, Edit} from "./class/logistic/LogistModel.js";
import {ViewProvider} from "./class/ProviderClass.js";
import {Company} from "./class/logistic/company.js";
import {UserService} from "./script.js";

document.addEventListener('DOMContentLoaded', function() {
    LogisticModel.getCity();
    LogisticModel.getPosition();
    $.mask.definitions['h'] = "[0|1|3|4|5|6|7|9]"
    $("#phone").mask("+7 (h99) 999 99 99");
    $('.seria').mask("9999");
    $('.numberPassport').mask("999999");
    $('#inputAddCompanyInn').mask("9999999999");
    $('#innCompanySearch').mask("9999999999");
    $('#kppCompanySearch').mask("999999999");
    $('.js-selectize').selectize();
    $('#companyProvider').selectize();

    const selectizeInstance = $('#select')[0].selectize;
    selectizeInstance.on('change', function(value) {
        Edit.addIconEditButton(selectizeInstance, document.querySelector('.labelSelect') , 'Компания');
    });

    const selectProvider = $('.companyProvider')[0].selectize;
    selectProvider.on('change', function(value) {
        Edit.addIconEditButton(selectProvider, document.querySelector('#selectProvider') , 'На получение от');
    });

    new clickController(document.querySelector('body'), Archive, ViewProvider, LogisticModel, UserService, Company, Edit);
    new changeController(document.querySelector('body'), ViewProvider, UserService, LogisticModel);
    new keyDownController(document.querySelector('input.search'), ViewProvider, UserService, LogisticModel);
})

/**
 * Очистка формы при закрытии модельного окна
 * @type {HTMLElement}
 */
let myModal2 = document.getElementById('exampleModal2');
myModal2.addEventListener('hide.bs.modal', () =>{
    const form = document.getElementById('dov');

    const inputs = form.querySelectorAll('input');

    inputs.forEach(item=>{
        item.value = ''
    })

    const select = $('#select')[0].selectize;
    const companyProvider = $('#companyProvider')[0].selectize;
    select.setValue();
    companyProvider.setValue();
});

/**
 * Возвращаем видимость формы Доверенность
 * после закрытия формы редактирования компании
 * @type {HTMLElement}
 */
let myModal3 = document.getElementById('editmodalCompany');
myModal3.addEventListener('hide.bs.modal', () =>{
    document.getElementById('exampleModal2').style.zIndex = '';
});

class clickController{

    constructor(elem, archive, provider, logistic , service , company , edit) {
        this.archive    = archive;
        this.provider   = provider;
        this.logistic   = logistic;
        this.service    = service;
        this.company    = company;
        this.edit       = edit;
        elem.onclick    = this.onClick.bind(this);
    }


    pageAttorney(event){

            if (!event.target.querySelector('.bi-trash')) {
                let id = event.target.closest('tr');
                window.location.href = `/attorney?id=${id.dataset.id}`;
            }

    }
    /**
     * обработчик при клике на ссылки
     */
    categories(event){
        document.querySelector("input.search").value = ' ';
        this.provider.addActive(event.target);
        this.logistic.getPosition(1, event.target.innerHTML);
    }

    /**
     * обработчик формы добавить при клике
    */
    addCompanyButton(event){
        this.service.validateForm('formAdd', '.AddLogisticSubmit');
        this.logistic.formAdd();
        // this.company.addCompany();
    }

    /**
     * Обработка события детальной информации о логисте
     */
    detail(event){
        const tr = event.target.closest('tr');
        this.logistic.getInfoLogistic(tr.dataset.id)
    }

    /**
     * Обработка события добавления номера доверенности
     */
    plus(event){
        this.#numberDover(event.target);
    }

    /**
     * Вывод модельного окна Добавления доверенности и вывод паспортных данных
     */
    dovAdd(event){
        const tr = event.target.closest('tr');
        document.getElementById('dov').dataset.id = tr.dataset.id;
        this.logistic.getPassport(tr.dataset.id);
        this.company.getCompany();
    }

    /**
     * Обработчик события редактирования компании
     */
    pen(event){
        let div = event.target.closest('.row');
        let id = div.querySelector('select').value;
        this.edit.getCompanyInfo(id);
    }

    /**
     * Обработка формы доверенности
     */
    submitDov(event){
        this.#emptyInput();
    }

    /**
     * Обработка формы редактирования компании
     * @param event
     */
    editCompanyButton(event){
        this.edit.updateCompany();
    }

    /**
     * поиск компании по ИНН
     */
    addCompanyInn(event){
        this.company.searchApi();
    }

    /**
     * Поиск данных банка по БИК
     */
    searchBank(event){
        this.company.searchBankApi();
    }

    /**
     * показ всех доверенностей
     */
    printArchive (event){
        this.archive.getAttorneyUser();
    }

    /**
     * Удаление доверенности
     * @param event
     */
    trash(event){
        this.archive.deleteAttorney(event);
    }

    /**
     * Обработка формы добавления компании
     */
    addMyCompany(event){
        document.getElementById('exampleModal2').style.zIndex = '1';

        this.service.modalShow('addProvider');

        let myModal = document.getElementById('addProvider');

        myModal.addEventListener('hide.bs.modal', () =>{
            document.getElementById('exampleModal2').style.zIndex = '';
        });
    }

    /**
     * обработчик событий на перелистывание страниц
     * @param event
     */
    pageLink(event){
        let searchValue = document.querySelector("input.search").value.trim();
        let page = parseInt(event.target.dataset.href);
        let active = ViewProvider.searchActive();

        if (searchValue !== '') {
            this.logistic.getPosition(page, searchValue);
        } else {
            if (active) {
                this.logistic.getPosition(page, active.innerHTML);
            } else {
                this.logistic.getPosition(page);
            }
        }
    }

    onClick(event) {
        let action = event.target.dataset.action;
        if (action && typeof this[action] === 'function') {
            this[action](event);
        }
    }

    #emptyInput (){
        const form = document.getElementById('dov');

        let inputs = form.querySelectorAll('input');
        let i = 0;
        inputs.forEach(item=>{
            if(item.value !== ''){
                i++;
            }
        })
        if(i !== 0){
            this.logistic.addDov();
        }else{
            console.log(i);
        }
    }

    /**
     * Функционал кнопки плюс окна доверенности
     * @param elem
     */
    #numberDover(elem){
        let value = document.querySelector('.number').value ?? 0;
        let matches = value.match(/(\D+)(\d+)/);
        if (matches) {
            let textPart = matches[1];
            let numberPart = parseInt(matches[2]);
            if (elem) {
                numberPart++;
                document.querySelector('.number').value = textPart + numberPart;
            }
        } else {
            let i = 0;
            if (elem) {
                i = parseInt(document.querySelector('.number').value) || 0;
                i++;
                document.querySelector('.number').value = i;
            }
        }
    }
}

class changeController {
    constructor(elem, provider, service, logistic) {
        this.provider = provider;
        this.service  = service;
        this.logistic  = logistic;
        elem.addEventListener('change', this.onChange.bind(this));  // Используем событие change
    }

    /**
     * обработчик вывода при поиске
     */
    search(event) {
        this.provider.clearActive ();
        this.#printSearch (event.target);
    }

    validate(event){
        this.service.validateForm('formAdd', '.AddLogisticSubmit')
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


    #printSearch (target) {
        let searchValue = target.value.trim();  // Используем target.value

        target.value = searchValue;  // Очищаем пробелы в поле ввода

        if (searchValue !== '') {
            this.logistic.getPosition(1, searchValue);
        } else {
            this.logistic.getPosition();
        }
    }
}

class keyDownController {
    constructor(elem, provider, service, logistic) {
        this.provider = provider;
        this.service  = service;
        this.logistic  = logistic;
        elem.addEventListener('keydown', this.keyDown.bind(this));  // Используем событие change
    }

    /**
     * обработчик нажатия enter
     * @param event
     */
    enter(event){
        this.provider.clearActive ();
        this.#printSearch (event);
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

    #printSearch (event){
        let searchValue = document.querySelector("input.search").value;

        document.querySelector("input.search").value = searchValue.trim();

        if (searchValue.trim() !== '') {

            this.logistic.getPosition(1, event.target.value.trim());

        }else{
            this.logistic.getPosition();
        }
    }
}






