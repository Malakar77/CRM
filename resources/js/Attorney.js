import { AttorneyModel } from "./class/ Attorney/AttorneyModel.js";


document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);

    let Attorney = new AttorneyModel(urlParams.get('id'));

    Attorney.searchDov();

    new Menu(document.getElementById('menu'), Attorney);

});

/**
 * Класс управления кнопками печать и скачать
 */
class Menu {
    constructor(elem, attorney) {
        this.attorney = attorney;
        elem.onclick = this.onClick.bind(this);
    }

    /**
     * Метод печати доверенности
     */
    print() {
        this.attorney.printAttorney();
    }

    /**
     * Метод для скачивания доверенности
     */
    download(){
        this.attorney.downloadAttorney();
    }


    onClick(event) {
        let action = event.target.dataset.action;
        if (action && typeof this[action] === 'function') {
            this[action]();
        }
    }
}
