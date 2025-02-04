import {Check} from "./class/check_total.js";

document.addEventListener('DOMContentLoaded', ()=>{
    new clickController(document.querySelector('body'), Check);
})

class clickController {
    constructor(elem, check)
    {
        this.check = check;
        elem.addEventListener('click', this.onClick.bind(this));
    }

    /**
     * Редактирование примечания
     */
    edit()
    {
        this.check.editComment();
    }

    /**
     * Печать счета
     */
    print()
    {
        this.check.print();
    }

    /**
     * Скачивание файла PDF
     */
    download()
    {
        this.check.download();
    }

    /**
     * Скачивание файла xlsx
     */
    xlsx()
    {
        this.check.downloadXlsx();
    }

    /**
     * Заполнение данными модельного окна
     */
    modalSentMail()
    {
        this.check.modalSentMail()
    }

    /**
     * Удаление прикрепленного файла
     */
    deleteFilePdf()
    {
        const pdf =  document.getElementById('pdfFile');
        if (pdf) {
            pdf.remove();
        }
    }

    /**
     * Отправка сообщения
     */
    sentEmail()
    {
        this.check.sentMail();
    }

    onClick(event)
    {
        let actionElement = event.target.closest('[data-click]');
        if (actionElement) {
            let action = actionElement.dataset.click;
            if (action && typeof this[action] === 'function') {
                this[action](event);
            }
        }
    }
}

