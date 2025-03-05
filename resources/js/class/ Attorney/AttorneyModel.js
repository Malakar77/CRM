import { UserService } from "../../script.js";

export class AttorneyModel{

    constructor(urlId)
    {
        this.urlId = urlId;
    }

    searchDov()
    {

        UserService.preLoad();

        fetch('Attorney/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.urlId}
            )
        }).then(response => response.json())
            .then(data => {
                UserService.deletePreloader(); // Вызов метода родителя
                this.#print(data);

            }).catch(error => {
                console.log(error)
                UserService.deletePreloader(); // Вызов метода родителя
                UserService.modalShow('error'); // Вызов метода родителя
            });
    }

    printAttorney()
    {

        UserService.preLoad();

        fetch('Attorney/print', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.urlId}
            )
        }).then(response => response.json())
            .then(data => {
                UserService.deletePreloader(); // Вызов метода родителя

                // Создаем новый объект для iframe
                let iframe = document.createElement('iframe');
                // Скрываем iframe
                iframe.style.display = 'none';
                // Устанавливаем src iframe на URL для печати
                iframe.src = data.original.url;
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

    downloadAttorney()
    {

        UserService.preLoad();

        fetch('Attorney/print', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(
                {'id' : this.urlId}
            )
        }).then(response => response.json())
            .then(data => {
                UserService.deletePreloader(); // Вызов метода родителя

                // Создаем новую ссылку для скачивания
                let downloadLink = document.createElement('a');
                downloadLink.href = data.original.url;  // Устанавливаем ссылку на файл
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

    #print(data)
    {


        let dateOt = '';
        if (data.date_ot) {
            dateOt =  UserService.formatDate(data.date_ot);
        }

        let dateDo = '';
        if (data.date_do) {
            dateDo =  UserService.formatDate(data.date_do);
        }
        let dateIssued = '';
        if (data.logist.date_issued) {
            dateIssued =  UserService.formatDate(data.logist.date_issued);
        }


        document.querySelector('.a1').innerText = data.numberDov ?? null;
        document.querySelector('.a2').innerText = dateOt['full'] ?? '';
        document.querySelector('.a3').innerText = dateDo['full'] ?? '';
        document.querySelector('.a4').innerText = data.logist.surname + ' ' + data.logist.name[0] + '. ' + data.logist.patronymic[0]+ '.' ?? null;
        document.querySelector('.a6').innerText = data.providerCompany.company_name ?? null;
        document.querySelector('.a8').innerText = data.info ?? null;

        document.getElementById('companyName').innerText = data.company.company_name ?? null;
        document.getElementById('numberDov').innerText = data.numberDov ?? null;
        document.getElementById('date_ot_day').innerText = dateOt['d'] ?? '';
        document.getElementById('date_ot_month').innerText = dateOt['m'] ?? '';
        document.getElementById('date_ot_yeas').innerText = dateOt['y'] ?? '';

        document.getElementById('date_do_day').innerText = dateDo['d'] ?? '';
        document.getElementById('date_do_month').innerText = dateDo['m'] ?? '';
        document.getElementById('date_do_yeas').innerText = dateDo['y'] ?? '';

        let companyDetails = data.company.company_name ?? '';
        companyDetails += data.company.inn_company ? ', ИНН: ' + data.company.inn_company : '';
        companyDetails += data.company.kpp_company ? ', КПП: ' + data.company.kpp_company : '';
        companyDetails += data.company.ur_address_company ? ' ' + data.company.ur_address_company : '';

        document.getElementById('company_name').innerText = companyDetails ;

        document.getElementById('companyDB').innerText = companyDetails;

        let checkDetails = data.company.ras_chet ? data.company.ras_chet + ', в ' : '';
        checkDetails += data.company.bank ? data.company.bank + ', БИК ' + data.company.bik_bank_company : '';
        checkDetails += data.company.kor_chet ? ', к/с ' + data.company.kor_chet : '';

        document.getElementById('check').innerText = checkDetails;

        document.getElementById('logistName').innerText = data.logist.surname + ' ' + data.logist.name + ' ' + data.logist.patronymic ?? null;
        document.getElementById('document').innerText = data.logist.document ?? null;
        document.getElementById('series').innerText = data.logist.series ?? null;
        document.getElementById('number').innerText = data.logist.number ?? null;

        document.getElementById('issued').innerText = data.logist.issued ?? null;
        document.getElementById('date_issued_day').innerText = dateIssued['d'];
        document.getElementById('date_issued_month').innerText = dateIssued['m'];
        document.getElementById('date_issued_yeas').innerText = dateIssued['y'];
        document.getElementById('companyProvider').innerText = data.providerCompany.company_name ?? null;
        document.getElementById('infoBlock').innerText = data.info ?? null;
    }

    static #emptyValue(data)
    {
        return (data) ? data : null
    }



}
