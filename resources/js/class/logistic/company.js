import { UserService } from "../../script.js";

export class Company extends UserService{
    /**
     * Метод получения данных о компаниях
     */
    static getCompany(){

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

            }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
        });
    }

    /**
     * Метод получения данных из Dadata по API
     * Данные по БИК о банке
     */
    static searchBankApi(){
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
     * Метод получения данных из Dadata по API
     * Поиск компании по ИНН
     */
    static searchApi(){

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
     * Добавление компании
     */
    static addCompany(){

        const form = document.getElementById('searchInn');

        let formData = new FormData(form);

        let formAddCompany = {};
        formData.forEach(function(value, key){
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
    static #clearInputs(){
        const form = document.getElementById('searchInn');
        const inputs = form.querySelectorAll('input');
        inputs.forEach(item=>{
            item.value = '';
        })
    }

    /**
     * Обработка ошибки при добавлении компании
     * @param id
     */
    static #error(id){

        const form = document.getElementById(id);
        let inputs = form.querySelectorAll('input');

        inputs.forEach(item => {
                item.classList.add('emptyInput');
        })
    }

    /**
     * Вывод данных о компании после поиска по ИНН
     * @param data объект данных из DaData
     */
    static #printCompany(data){
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
    static #printBank(data){
        document.getElementById('bank').value = data.suggestions[0].value;
        document.getElementById('korChet').value = data.suggestions[0].data.correspondent_account	;
    }

    /**
     * Вспомогательный метод заполнения Select данными
     * @param data
     */
    static #printAddCompany(data){

        const select = $('#select')[0].selectize; // Получаем инстанс selectize
        const companyProvider = $('#companyProvider')[0].selectize; // Получаем инстанс selectize

        select.clearOptions();
        companyProvider.clearOptions();

        // Добавляем новые опции
        for(let i = 0; i < data.length; i++){
            select.addOption({value: data[i].id, text: data[i].company_name});
            companyProvider.addOption({value: data[i].id, text: data[i].company_name});
        }
    }
}
