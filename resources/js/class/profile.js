import {UserService} from "../script.js";

export class Profile extends UserService{

    /**
     * Запись данных о почте
     */
    static setSignature()
    {
        const form = {
            'id' : document.getElementById('pass').dataset.id,
            'pass' : document.getElementById('pass').value,
            'signature' : document.getElementById('text_signature').value,
        }

        this.preLoad();

        fetch('/profile/setSignature', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(form),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Установка аватарки
     */
    static setAvatar()
    {
        let error = false; // Используем флаг вместо числа
        let file = '';

        if (document.getElementById('ava')) {
            // Получаем элемент input с типом file
            let fileInput = document.getElementById('ava');
            file = fileInput.files[0];

            if (fileInput.files[0] === undefined) {
                document.getElementById('ava').style.border = '1px solid red';
            } else {
                document.getElementById('ava').style.border = '1px solid green';
            }

            // Проверяем, был ли выбран файл
            if (file) {
                let maxFileSize = 50 * 1024 * 1024; // Максимальный размер файла: 10 МБ

                // Проверяем размер файла
                if (file.size > maxFileSize) {
                    document.querySelector('.errorFile').innerHTML = "Файл слишком большой. Максимальный размер: " + (maxFileSize / (1024 * 1024)) + " МБ."
                    document.getElementById('ava').style.border = '1px solid red';
                    document.querySelector('.errorFile').style.color = 'red';
                    error = true; // Устанавливаем флаг в true при неудачной проверке
                }

                const mimeType = file.type;

                if (mimeType !== 'image/jpeg' && mimeType !== 'image/png') {
                    document.querySelector('.errorFile').innerHTML = 'Не допустимый формат';
                    document.querySelector('.errorFile').style.color = 'red';
                    document.getElementById('ava').style.border = '1px solid red';
                    error = true;
                }
            } else {
                document.getElementById('ava').style.border = '1px solid red';
                error = true; // Устанавливаем флаг в true при отсутствии файла
            }
        }

        if (error) { // Проверяем флаг
            return false;
        }

        document.querySelector('.errorFile').innerHTML = 'Фаил формата jpg/png';
        document.querySelector('.errorFile').style.color = '#fff';

        this.preLoad();

        let formData = new FormData();
        formData.append('file', file);
        formData.append('id', document.getElementById('pass').dataset.id);

        fetch('/profile/setFile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.getElementById('photo').src = data;
                document.querySelector('img.rounded-circle').src = data;
                document.getElementById('ava').value = '';
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Установка имени пользователя
     */
    static setName()
    {
        let name = {
            'name' : document.getElementById('name').value.trim(),
            'surname' : document.getElementById('surname').value.trim(),
            'patronymic' : document.getElementById('patronymic').value.trim(),
            'id' : document.getElementById('name').dataset.id.trim()
        }

        this.preLoad();

        fetch('/profile/setName', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(name),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader();
                document.getElementById('nameUser').textContent = data;
                document.querySelector('p.post').textContent = data;
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }
}
