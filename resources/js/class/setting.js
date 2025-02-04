import {UserService} from "../script.js";

class Service extends UserService{

    /**
     * Вывод общей информации о пользователе
     */
    static index()
    {
        this.preLoad();

        fetch('/setting/index', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                if (data['user'].admin === true) {
                    document.getElementById('admin').checked = true;
                }

                if (data['user'].work === true) {
                    document.getElementById('work').checked = true;
                }

                Service.#printName('nameAllUser', data);
                Service.#printPost('department', data['post'], data['user'].otdel);
                Service.#printPost('post_user', data['department'], data['user'].dolzhost);
                this.printUser(data['user'])

            }).catch(error => {
                console.log(error.message)
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Вспомогательный вывод общей информации о пользователе
     */
    static #printName(elem, data)
    {
        const name = document.getElementById(elem);
        for (let i = 0; i < data['name'].length; i++) {
            let option = document.createElement('option');
            option.value = data['name'][i].id;
            option.textContent = data['name'][i].name;
            if (data['user'].id === data['name'][i].id) {
                option.selected = true;
            }
            name.append(option);
        }
    }

    /**
     * Вывод данных о должности/отделе
     * @param elem
     * @param data
     * @param user
     */
    static #printPost(elem, data, user)
    {
        const select = document.getElementById(elem)
        const options = select.options; // Получаем все option элементы

        // Удаляем все option элементы, начиная с 1-го (индекс 0 - это первый элемент)
        for (let i = options.length - 1; i > 0; i--) {
            select.remove(i);
        }

        for (let i = 0; i < data.length; i++) {
            let option = document.createElement('option');
            option.value = data[i].id;
            option.textContent = data[i].name;
            if (user === data[i].id) {
                option.selected = true;
            }
            select.append(option);
        }
    }

    /**
     * Вывод данных о пользователе
     * @param data
     */
    static printUser(data)
    {
        document.querySelector('.body').dataset.id = data.id;
        document.getElementById('photo').src =  data.link_ava;
        document.getElementById('admin').checked = data.admin;
        document.getElementById('work').checked = data.work;
        document.getElementById('post').textContent = data.otdel;
        document.getElementById('youth').textContent = data.dolzhost;
        document.getElementById('prefix').value = data.prefix;
        document.getElementById('numberCheck').value = data.numberCheck;
        document.getElementById('numberContract').value = data.numberContract;
        document.getElementById('salary').value = data.oklad;
        document.getElementById('bonus_do').value = data.zp_do_plan;
        document.getElementById('bonus_after').value = data.zp_posl_plan;

        const selectOne = document.getElementById('department');
        for (let i = 0; i < selectOne.options.length; i++) {
            selectOne.options[i].selected = parseInt(selectOne.options[i].value) === data.id_otdel;
        }

        const selectTwo = document.getElementById('post_user');
        for (let i = 0; i < selectTwo.options.length; i++) {
            selectTwo.options[i].selected = parseInt(selectTwo.options[i].value) === data.id_dolzhost;
        }

    }
}

export class Setting extends Service{

    /**
     * Вывод данных о пользователе
     */
    static userSelection()
    {
        this.preLoad();

        fetch('/setting/userSelected', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'id' : document.getElementById('nameAllUser').value.trim()
            })
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                this.printUser(data);
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Сохранение данных о пользователе
     */
    static save()
    {
        let admin = false;
        if (document.getElementById('admin').checked === true) {
            admin = true;
        }

        let work = false;
        if (document.getElementById('work').checked === true) {
            work = true;
        }

        const user = {
            'id'            : document.querySelector('.body').dataset.id,
            'admin'         : admin,
            'work'          : work,
            'post'          : document.getElementById('department').value,
            'youth'         : document.getElementById('post_user').value,
            'prefix'        : document.getElementById('prefix').value,
            'numberCheck'   : document.getElementById('numberCheck').value,
            'numberContract': document.getElementById('numberContract').value,
            'salary'        : document.getElementById('salary').value,
            'bonus_do'      : document.getElementById('bonus_do').value,
            'bonus_after'   : document.getElementById('bonus_after').value,
        }

        this.preLoad();

        fetch('/setting/setUsers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(user)
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });


    }

    /**
     * Открытие модельного окна
     */
    static add()
    {
        this.modalShow('add');
    }


    /**
     * Запись новой должности/отдела
     * @returns {boolean}
     */
    static save_post()
    {
        const postTypeElem = document.getElementById('post_type');
        const postNameElem = document.getElementById('add_name');

        if (!postTypeElem || !postNameElem) {
            console.error('Required elements not found.');
            return false;
        }

        let form = {
            'type': postTypeElem.value,
            'name': postNameElem.value,
        };

        for (const formKey in form) {
            if (form[formKey] === '') {
                postTypeElem.classList.add('error');
                postNameElem.classList.add('error');
                return false;
            }
        }

        this.preLoad(); // Show preloader

        fetch('/setting/setPost', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(form)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                this.deletePreloader(); // Hide preloader
                let selectPost = document.getElementById('department');
                let selectDep = document.getElementById('post_user');

                let option = document.createElement('option');
                option.value = data.id;
                option.textContent = data.name;
                option.selected = true;
                if (data.type === 'post') {
                    selectPost.append(option);
                } else {
                    selectDep.append(option);
                }
                this.modalHide('add');
            })
            .catch(error => {
                this.deletePreloader(); // Hide preloader
                this.modalShow('error'); // Show error modal
                return false; // Failed request
            });
    }




}
