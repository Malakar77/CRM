import {UserService} from "../../script.js";

export class Validate extends UserService{
    /**
     * Валидация формы
     * @returns {boolean}
     */
    static validateForm(form)
    {

        let hasError = false;

        for (const key in form) {
            if (form[key].value.trim() === '') {
                form[key].classList.add('error_input');
                hasError = true;
            } else {
                form[key].classList.remove('error_input');
            }
        }

        return !hasError;

    }
}
