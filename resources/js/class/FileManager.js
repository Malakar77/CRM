import {UserService} from "../script.js";

export class Service extends UserService{

    static close()
    {

        this.modalHide('notify');
    }
}
