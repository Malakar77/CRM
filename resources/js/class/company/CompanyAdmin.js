import {UserService} from "../../script.js";

export class CompanyAdmin extends UserService{


    /**
     * Назначение менеджера
     */
    static editCompany()
    {
        const inputs = document.querySelectorAll('.form-check-input');
        let select = document.querySelector('.selectManager').value;
        let name = document.querySelector('.nameText').value;

        if (name.trim() === '') {
            document.querySelector('.nameText').classList.add('error');
            return false;
        }

        const companyIds = {
            id: [],
            id_manager: [],
            name_export: []
        };

        inputs.forEach(input => {
            if (input.checked) {
                companyIds['id'].push(input.closest('tr').dataset.id);
            }
        });

        companyIds['id_manager'] = select;
        companyIds['name_export'] = name;

        this.preLoad();

        fetch('companyCall/setManager',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(companyIds),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
                this.modalHide('selectManagerModal');
                inputs.forEach(input => {
                    if (input.checked && companyIds['id'].includes(input.closest('tr').dataset.id)) {
                        let tr = input.closest('tr');
                        tr.remove();
                    }
                });
                this.unload();
            }).catch(error => {
                this.deletePreloader();
                this.modalShow('error');
            });
    }

    /**
     * Метод удаления компаний
     */
    static deleteCompany()
    {

        const inputs = document.querySelectorAll('.form-check-input');

        const deleteCompany = [];

        inputs.forEach(input => {
            if (input.checked) {
                deleteCompany.push(input.closest('tr').dataset.id);
            }
        });

        this.preLoad();
        fetch('companyCall/deleteCompany',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(deleteCompany),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
                inputs.forEach(input => {
                    if (input.checked && deleteCompany.includes(input.closest('tr').dataset.id)) {
                        let tr = input.closest('tr');
                        tr.remove();
                    }
                });

            }).catch(error => {
                this.deletePreloader();
                this.modalShow('error');
            });
    }

    /**
     * Метод заполнения данными select
     */
    static addManager()
    {
        this.preLoad();
        fetch('companyCall/getManager', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'manager' : true
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
                this.#countCompany();
                this.#addManager(data);

            }).catch(error => {
                this.deletePreloader();
                this.modalShow('error');
            });
    }

    /**
     * Метод вывода списка компаний из выгрузки
     * @param elem
     */
    static infoExport(elem)
    {
        let tr = elem.target.closest('tr');

        this.preLoad();

        fetch('companyCall/infoUnload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'name' : tr.children[0].textContent,
                'page' : 1,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
                // document.querySelector('.exportList').innerHTML = '';
                this.#printCompany(data[1]);
                document.querySelector('.paginatorNav').innerHTML = '';
                this.paginatorNav(data[0], data[2]);
            }).catch(error => {
                this.deletePreloader();
                this.modalShow('error');
            });
    }


    /**
     * Добавление класса active
     * @param elem
     */
    static addActive(elem)
    {
        let tr = elem.target.closest('tr');
        tr.classList.add('active');
    }

    /**
     * Удаление класса active
     */
    static removeActive()
    {
        let table = document.querySelector('.exportList');
        let tr = table.querySelectorAll('tr');
        tr.forEach(item =>{
            item.classList.remove('active');
        })
    }
    /**
     * Метод вывода списка выгрузок
     */
    static unload()
    {
        this.preLoad();

        fetch('companyCall/writeUnload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'unLoad': true,
            }),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();

                this.#printExport(data)
            }).catch(error => {
                this.deletePreloader();
                this.modalShow('error');
            });
    }

    /**
     * Метод вывода компаний с пагинацией
     * @param position
     * @param page
     * @param status
     */
    static writeCompany(position = 'all', page = 1, status='add')
    {
        let all = {
            'position': position,
            'page' : page,
            'status' : status
        };

        this.preLoad();

        fetch('companyCall/writeCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(all),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                // document.querySelector('.exportList').innerHTML = '';
                if (data[1]) {
                    this.#printCompany(data[1]);
                    document.querySelector('.paginatorNav').innerHTML = '';
                    this.paginatorNav(data[0], data[2])
                }


            }).catch(error => {
                console.log(error)
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод добавления в базу данных из файла
     */
    static sentFile()
    {

        const form = document.getElementById('formSearch');
        let formFile = new FormData(form);

        //запускаем таймер
        CompanyService.timeSt();

        //блокируем все кнопки закрыть
        let close = document.querySelectorAll('.butClose');
        close.forEach(item=>{
            item.disabled = true;
        })

        //блокируем кнопку загрузить
        document.querySelector('.saveCompany').disabled = true;

        // блокируем выбор файла
        document.querySelector('.inputFile').disabled = true;

        // добавляем лоадер при отправке запроса
        let div = document.createElement('span');
        div.className = "loader";
        document.querySelector('.body').append(div);

        fetch('companyCall/addCompany', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formFile,
        }).then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети: ' + response.status);
            }
            return response.json();
        }).then(data => {
            CompanyService.funST();
            this.modalHide('exampleModal');
            form.reset();
            // выводим JSON-ответ
            document.getElementById('errorBlock').innerHTML = '';
            document.getElementById('formFile').style.border = 'var(--bs-border-width) solid var(--bs-border-color);';
            document.getElementById('formFile').style.borderColor = ' ';
        }).catch(error => {

            CompanyService.funST();
            // //выводим окно ошибки
            this.modalShow('error'); // Вызов метода родителя
        });
    }

    /**
     * Заполнение Данными select
     * @param data
     */
    static #addManager(data)
    {
        let select = document.querySelector('.selectManager');
        select.innerHTML = "";
        for (let i=0; i<data.length; i++) {
            let option = document.createElement('option');
            option.value = data[i].id;
            option.innerHTML = data[i].name;
            select.append(option);
        }
    }

    /**
     * функция подсчёта количества выбранных компаний
     */
    static #countCompany()
    {
        const inputs = document.querySelectorAll('.form-check-input');
        let count = 0;
        inputs.forEach(input => {
            if (input.checked) {
                count = count +1;
            }
        });
        document.querySelector('.count').innerHTML = '<p>Выбрано компаний: '+count+'</p>';
    }

    /**
     * Метод вывода списка компаний
     * @param result
     */
    static #printCompany(result)
    {

        const block = document.querySelector('.exportListCompany');
        block.innerHTML = "";

        for (let i = 0; i<result.length; i++) {
            let tr = document.createElement('tr');
            tr.dataset.id=result[i].id;
            tr.innerHTML = `

            <td data-action="tdCheck">
            <input class="form-check-input" type="checkbox" data-action="checkInput" type="checkbox">
            </td>
            <td data-action="tdCheck">${result[i].inn}</td>

            <td data-action="tdCheck" style="width: 50px;">${result[i].name}</td>

            <td data-action="tdCheck">${result[i].address}</td>
            <td data-action="tdCheck">
            <span class="badge text-bg-primary"
            type="button"
            data-bs-container="body"
            data-bs-toggle="popover"
            data-bs-placement="top"
            data-bs-content="${result[i].status}">${result[i].status}
            </span>
            </td>
            `;
            block.append(tr);
        }
    }

    /**
     * Метод вывод списка выгрузок
     * @param result
     */
    static #printExport(result)
    {
        let block = document.querySelector('.exportList');
        block.innerHTML = "";

        for (let i = 0; i<result.length; i++) {
            let tr = document.createElement('tr');
            let date = this.formatDate(result[i].date_export);

            tr.innerHTML = `
            <td data-action="active" style="font-size: 12px;">${result[i].name_export}</td>
            <td data-action="active" style="font-size: 12px;">${date['full']}</td>
            <td data-action="active" style="font-size: 12px;">${this.abbreviateName(result[i].name)}</td>
            <td data-action="active">
                <span class="badge text-bg-primary">${result[i].count}</span>
            </td>
            `;
            block.append(tr);
        }
    }
}




export class CompanyService extends UserService{
    constructor()
    {
        super(); // Вызов конструктора родительского класса
    }

    static intervalId = '';


    /**
     * Функция добавления выбора компании при нажатии на td
     */
    static clickChecked(elem)
    {
        let tr = elem.target.closest('tr');
        let input = tr.querySelector('input');
        input.checked = input.checked === false;
    }

    /**
     * Метод выбора компаний
     */
    static checked(elem)
    {
        const inputs = document.querySelectorAll('.form-check-input');
        let allChecked = true;


        let target = '';

        if (elem.target.tagName === 'BUTTON') {
            target = elem.target.querySelector('i');
        } else {
            target = elem.target;
        }

        // Проверяем, все ли элементы выбраны
        inputs.forEach(input => {
            if (!input.checked) {
                allChecked = false;
            }
        });

        // Если все элементы выбраны, снимаем выбор с каждого элемента
        if (allChecked) {
            inputs.forEach(input => {
                input.checked = false;
            });
            target.style.color = '#fff';
            this.disableBut();
        } else {
            // Если не все элементы выбраны, выбираем все элементы
            inputs.forEach(input => {
                input.checked = true;
            });
            target.style.color = '#36bb28';
            this.disableBut();
        }
    }

    /**
     * Метод блокировки кнопок редактирования
     */
    static disableBut()
    {
        const but = document.querySelector('.delete');
        const addManager = document.querySelector('.addManager');
        const inputs = document.querySelectorAll('.form-check-input');
        let hasChecked = false;

        // Проверяем, есть ли хотя бы один выделенный элемент
        inputs.forEach(input => {
            if (input.checked) {
                hasChecked = true;
            }
        });

        // Если есть выделенные элементы, разблокируем кнопку
        if (hasChecked) {
            but.disabled = false;
            but.style.color = "#ffffff";
            addManager.disabled = false;
            addManager.style.color = "#ffffff";
        } else {
            // Если нет выделенных элементов, блокируем кнопку
            but.disabled = true;
            but.style.color = "#495057";
            addManager.disabled = true;
            addManager.style.color = "#495057";
        }
    }

    /**
     * таймер выполнения
     */
    static timeSt()
    {
        let i = 0;
        CompanyService.intervalId = setInterval(function () {
            let minutes = Math.floor(i / 60);
            let seconds = i % 60;
            let formattedTime = `${minutes}.${seconds.toString().padStart(2, '0')}`;
            document.getElementById('errorBlock').innerHTML = `Время загрузки файла: ${formattedTime} мин.`;
            i++;
        }, 1000); // Обновление каждую секунду (1000 миллисекунд)
    }

    /**
     * остановка таймера выполнения
     */
    static funST()
    {
        this.deletePreloader(); // Вызов метода родителя
        //останавливаем таймер
        clearInterval(CompanyService.intervalId);
        //разблокируем кнопки закрыть
        let close = document.querySelectorAll('.butClose');
        close.forEach(item=>{
            item.disabled = false;
        })
        //разблокируем кнопку загрузить
        document.querySelector('.saveCompany').disabled = false;
        //разблокируем кнопку выбора файла
        document.querySelector('.inputFile').disabled = false;
    }

    /**
     * Валидация формы загрузки данных
     * @returns {boolean}
     */
    static validateFormFile()
    {
        const fileInput = document.getElementById('formFile');

        // Проверяем, был ли выбран файл
        if (fileInput.files.length === 0) {
            fileInput.style.border = '1px Solid red';
            document.getElementById('errorBlock').innerHTML = 'Фаил не выбран';
            document.getElementById('errorBlock').style.color = 'red';
            return false; // Возвращаем false, чтобы предотвратить отправку формы
        }

        if (fileInput.files[0].size > 1000000) {
            fileInput.style.border = '1px Solid red';
            document.getElementById('errorBlock').innerHTML = 'Фаил превышает допустимый размер в 1 МБ';
            document.getElementById('errorBlock').style.color = 'red';
            return false;
        }

        if (fileInput.files[0].type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            fileInput.style.border = '1px Solid red';
            document.getElementById('errorBlock').innerHTML = 'Формат файла не соответствует .xlsx';
            document.getElementById('errorBlock').style.color = 'red';
            return false;
        } else {
            fileInput.style.border = '1px Solid green';
            document.getElementById('errorBlock').innerHTML = ' ';
            document.getElementById('errorBlock').style.color = 'white';
            return true;
        }
    }

}
