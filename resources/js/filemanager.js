import { Service} from "./class/FileManager.js";

document.addEventListener('DOMContentLoaded', ()=> {
    new clickController(document.querySelector('body'), Service);
})
class clickController {
    constructor(elem, service)
    {
        this.service = service
        elem.onclick = this.onClick.bind(this);
    }

    closeModal(elem)
    {
        const modal = elem.target.closest('#notify');


        this.service.close();
    }

    /**
     * Метод обработки клика
     * @param event
     */
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
