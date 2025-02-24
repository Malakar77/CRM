import {UserService} from "../script.js";
import {Validate} from "./helper/Validate.js";
export class Service extends UserService {

    /**
     * Валидация формы
     * @returns {boolean}
     */
    static validateForm()
    {

        const formFields = this.getFormFields();

        if (!Validate.validateForm(formFields)) {
            this.showErrorMessage("Проверьте введенные вами данные");
            return false;
        }

        this.sendData();
    }

    /**
     * Получает поля формы
     * @returns {Object}
     */
    static getFormFields()
    {
        return {
            innCompany: document.querySelector('.nameCompany'),
            login: document.querySelector('.login'),
            password: document.querySelector('.pass'),
            password_confirmation: document.querySelector('.passField'),
        };
    }

    /**
     * Собирает данные формы
     * @returns {Object}
     */
    static collectFormData()
    {
        const fields = this.getFormFields();
        return {
            innCompany: fields.innCompany.value.trim(),
            login: fields.login.value.trim(),
            password: fields.password.value.trim(),
            password_confirmation: fields.password_confirmation.value.trim(),
        };
    }


    /**
     * Отправка данных на сервер
     */
    static sendData()
    {
        const button = document.querySelector('.glow-on-hover');
        button.classList.add('sent');
        this.preLoad();
        this.clearErrorMessage();

        const data = this.collectFormData();

        fetch('/api/send-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(data),
        })
            .then(response => {
                this.deletePreloader();
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                this.handleSuccess(data);
            })
            .catch(error => {
                this.handleError(error);
            });
    }

    /**
     * Обработка успешного ответа
     * @param {Object} data
     */
    static handleSuccess(data)
    {
        document.querySelector('.glow-on-hover').classList.remove('sent');
        this.deletePreloader();
        this.showErrorMessage(data.message);
        this.clearFormFields();
        this.redirectAfterDelay('/');
    }

    /**
     * Обработка ошибки
     * @param {Object} error
     */
    static handleError(error)
    {
        document.querySelector('.glow-on-hover').classList.remove('sent');
        this.deletePreloader();
        if (error.error) {
            this.showErrorMessage(error.error);
        }
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
     * Очистка полей формы
     */
    static clearFormFields()
    {
        document.querySelectorAll('input').forEach(input => input.value = '');
    }

    /**
     * Перенаправление через несколько секунд
     * @param {string} url
     * @param {number} delay
     */
    static redirectAfterDelay(url, delay = 3000)
    {
        let counter = 3;
        const interval = setInterval(() => {
            this.showErrorMessage(`Вы будете перенаправлены на страницу входа через ${counter}`);
            counter--;
            if (counter < 0) {
                clearInterval(interval);
                window.location.href = url;
            }
        }, 1000);
    }
}

