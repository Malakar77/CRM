import {UserService} from "../script.js";

export class Service extends UserService{
    /**
     * Метод редактирования примечания
     */
    static editComment()
    {
        /* редактирование примечания */
        let elements = document.querySelectorAll('.edit');
        let param = {};

        for (let i = 0; i < elements.length; i++) {
            let elem = elements[i];

            if (!elem.dataset.editing) {
                // Если редактирование не начато
                let input = document.createElement('textarea');
                input.style.width = '100%';
                input.style.height = '100%';
                input.value = elem.innerText.replace(/(<br>)/g, '');
                elem.innerHTML = '';
                elem.appendChild(input);
                elem.dataset.editing = "true"; // Устанавливаем флаг редактирования
            } else {
                // Если редактирование уже начато, возвращаем исходный текст
                let textarea = elem.querySelector('textarea');
                if (textarea) {
                    elem.innerHTML = textarea.value.replace(/\n/g, '<br>');
                    param['text'] = textarea.value.replace(/\n/g, '<br>');
                    param['id'] = this.getParam('check');
                    this.fetchComment(param);
                    console.log(param);
                }
                delete elem.dataset.editing; // Сбрасываем флаг редактирования
            }
        }
    }

    /**
     * Запрос в бд на запись данных комментария
     * @param param
     */
    static fetchComment(param)
    {
        this.preLoad();

        fetch('/check_total/setComment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(param),
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }



}

export class Check extends Service{

    /**
     * Метод печати счета
     */
    static print()
    {
        this.preLoad();
        fetch('/check_total/getFile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.getParam('check')}
            )
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                // Создаем новый объект для iframe
                let iframe = document.createElement('iframe');
                // Скрываем iframe
                iframe.style.display = 'none';
                // Устанавливаем src iframe на URL для печати
                iframe.src = data.url;
                // Добавляем iframe на страницу
                document.body.appendChild(iframe);
                // Подождем некоторое время для загрузки контента в iframe
                setTimeout(function () {
                    // Вызываем функцию print() для печати
                    iframe.contentWindow.print();
                    // Удаляем iframe после печати
                    // document.body.removeChild(iframe);
                }, 1000); // Используем значение времени ожидания, необходимое для загрузки контента в iframe

            }).catch(error => {
                UserService.deletePreloader(); // Вызов метода родителя
                UserService.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод скачивания счета PDF
     */
    static download()
    {

        this.preLoad();

        fetch('/check_total/getFile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.getParam('check')}
            )
        }).then(response => response.json())
            .then(data => {
                UserService.deletePreloader(); // Вызов метода родителя

                // Создаем новую ссылку для скачивания
                let downloadLink = document.createElement('a');
                downloadLink.href = data.url;  // Устанавливаем ссылку на файл
                downloadLink.download = '';  // Атрибут download указывает, что нужно скачать
                downloadLink.style.display = 'none';  // Скрываем ссылку

                // Добавляем ссылку на страницу
                document.body.appendChild(downloadLink);

                // Инициируем клик на ссылке для скачивания файла
                downloadLink.click();

                // Удаляем ссылку после скачивания
                document.body.removeChild(downloadLink);

            }).catch(error => {
                UserService.deletePreloader(); // Вызов метода родителя
                UserService.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Метод скачивания счета Xlsx
     */
    static downloadXlsx()
    {
        this.preLoad();

        fetch('/check_total/exelCheck', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.getParam('check')}
            )
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя

                // Создаем новую ссылку для скачивания
                let downloadLinkXlsx = document.createElement('a');
                downloadLinkXlsx.href = data.url;  // Устанавливаем ссылку на файл
                downloadLinkXlsx.download = '';  // Атрибут download указывает, что нужно скачать
                downloadLinkXlsx.style.display = 'none';  // Скрываем ссылку

                // Добавляем ссылку на страницу
                document.body.appendChild(downloadLinkXlsx);

                // Инициируем клик на ссылке для скачивания файла
                downloadLinkXlsx.click();

                // Удаляем ссылку после скачивания
                document.body.removeChild(downloadLinkXlsx);

            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Заполнение модельного окна
     */
    static modalSentMail()
    {
        this.preLoad();

        fetch('/check_total/dataCompany', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.getParam('check')}
            )
        }).then(response => response.json())
            .then(data => {
                this.deletePreloader(); // Вызов метода родителя
                document.getElementById('emailCompany').value = data.email;
                document.getElementById('subject').value = data.name;
                document.getElementById('nameFileEmail').innerHTML = '';

                let pdf = document.createElement('div');
                pdf.id = 'pdfFile';

                pdf.innerHTML = `
                <i class="bi bi-filetype-pdf" style="color: red; vertical-align: initial;"></i>
                    ${data.name}.pdf
                <i class="bi bi-x-lg  closeTegI" data-click="deleteFilePdf"></i>`;

                document.getElementById('nameFileEmail').append(pdf) ;
            }).catch(error => {
                this.deletePreloader(); // Вызов метода родителя
                this.modalShow('error'); // Вызов метода родителя
            });
    }

    /**
     * Отправка сообщения
     */
    static sentMail()
    {

        let file = !!(document.getElementById('nameFileEmail').innerHTML.trim());
        const form =  document.getElementById('staticBackdrop');
        const input = form.querySelectorAll('input');
        input.forEach(item=>{
            item.style.border = '';
        })
        const email = {
            'emailCompany' : document.getElementById('emailCompany').value.trim(),
            'subject' : document.getElementById('subject').value.trim(),
            'textEmail' : document.getElementById('textEmail').value.trim().replace(/\n/g, '<br>'),
            'check': this.getParam('check'),
            'file' : file
        }

        this.preLoad();

        fetch('/check_total/sentEmail', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                email
            )
        }).then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw errorData;  // Пробрасываем ошибки для обработки
                });
            }
            return response.json();
        }).then(data => {
            this.deletePreloader(); // Вызов метода родителя
            this.modalHide('staticBackdrop');
        }).catch(error => {
            this.deletePreloader(); // Вызов метода родителя
            if (error) {
                input.forEach(item=>{
                    item.style.border = '1px solid red';
                })
            }
        });

    }

}
