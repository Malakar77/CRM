import {UserService} from "../script.js";
import {Validate} from "./helper/Validate.js";

export class Service extends UserService{

    static validateFormLogin()
    {
        const formFields = this.getFormFields();

        if (!Validate.validateForm(formFields)) {
            this.showErrorMessage("Проверьте введенные вами данные");
            return false;
        }

        this.authUser();
    }

    /**
     * Получает поля формы
     * @returns {Object}
     */
    static getFormFields()
    {
        return {
            login : document.getElementById('login'),
            password : document.getElementById('password'),
        };
    }

    /**
     * Отображение сообщения об ошибке
     * @param {string} message
     */
    static showErrorMessage(message)
    {
        document.querySelector('.error').innerText = message;
    }

    /**
     * Очистка сообщения об ошибке
     */
    static clearErrorMessage()
    {
        document.querySelector('.error').innerText = '';
    }

    /**
     * Собирает данные формы
     * @returns {Object}
     */
    static collectFormData()
    {
        const fields = this.getFormFields();
        return {
            login: fields.login.value.trim(),
            password: fields.password.value.trim(),
        };
    }

    static addSent()
    {
        const button = document.querySelector('.glow-on-hover');
        button.classList.add('sent');
    }

    static deleteSent()
    {
        const button = document.querySelector('.glow-on-hover');
        button.classList.remove('sent');
    }

    /**
     * Очистка полей формы
     */
    static clearFormFields()
    {
        document.querySelectorAll('input').forEach(input => input.value = '');
    }

    static redirectAfterDelay()
    {
        // Обратный отсчет перед перенаправлением на страницу входа
        let i = 3;
        let interval = setInterval(function () {
            document.querySelector('.error').innerHTML = 'Будете перенаправлены через ' + i + ' секунды';
            i--;
            if (i < 0) {
                clearInterval(interval); // Останавливаем интервал
                window.location.href = '/api/main'; // Перенаправляем на страницу входа
            }
        }, 1000);
    }

    /**
     * Обработка успешного ответа
     * @param {Object} data
     */
    static handleSuccess(data)
    {
        this.deleteSent();
        this.showErrorMessage(data.message);
        this.clearFormFields();
        this.redirectAfterDelay('/api/main');
    }

    static authUser()
    {
        // Очищаем предыдущее сообщение об ошибке
        this.clearErrorMessage();

        this.addSent();

        const data = this.collectFormData();

        fetch('/api/auth-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                this.deleteSent();
                if (!response.ok) {
                    return response.json().then(err => { throw err });
                }
                return response.json();
            })
            .then(data => {
                this.handleSuccess(data);
            })
            .catch((error) => {
                this.deleteSent();
                if (error.error) {
                    this.showErrorMessage(error.error);
                }
            });
    }
}
