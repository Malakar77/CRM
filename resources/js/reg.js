import {UserService} from "./script.js";

document.addEventListener('click', (e) => {
    /**
     * Обрабатываем клик по кнопке "Назад".
     * При нажатии на элемент с классом 'butBack' происходит перенаправление на главную страницу.
     */
    if (e.target.classList.contains('butBack')) {
        window.location.href = '/';
    }

    /**
     * Обрабатываем клик по кнопке "Зарегистрировать".
     * При нажатии на элемент с классом 'glow-on-hover' добавляем прелоадер,
     * изменяем состояние кнопки и запускаем функцию отправки данных.
     */
    if (e.target.classList.contains('glow-on-hover')) {
        // Показать прелоадер
        let loader = document.createElement('span');
        loader.className = "loader";
        document.getElementById('login_form').append(loader);

        // Добавляем класс 'sent' к кнопке, чтобы показать, что процесс отправки запущен
        document.querySelector('.glow-on-hover').classList.add('sent');

        // Запускаем функцию для отправки данных на сервер
        sendData();
    }
});

/**
 * Функция для отправки данных с помощью Fetch API.
 * Отправляет данные формы на сервер, показывает/удаляет прелоадер,
 * обрабатывает ответы сервера и ошибки.
 */
function sendData() {
    // Очищаем предыдущее сообщение об ошибке
    document.querySelector('.error').innerHTML = ' ';

    // Сбор данных из формы
    const data = {
        innCompany: document.querySelector('.nameCompany').value.trim(),
        login: document.querySelector('.login').value.trim(),
        password: document.querySelector('.pass').value.trim(),
        password_confirmation: document.querySelector('.passField').value.trim(),
    };

    // Отправка данных на сервер
    fetch('/api/send-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            // Удаляем прелоадер после получения ответа
            UserService.deletePreloader();

            // Если статус ответа не в диапазоне 200-299, выбрасываем ошибку
            if (!response.ok) {
                return response.json().then(err => { throw err });
            }

            // Возвращаем данные в формате JSON
            return response.json();
        })
        .then(data => {
            // Удаляем прелоадер, если всё прошло успешно
            UserService.deletePreloader();

            // Отображаем сообщение с сервера
            document.querySelector('.error').innerHTML = data.message;

            // Очищаем все поля формы после успешной отправки
            let form = document.querySelectorAll('input');
            form.forEach(item => {
                item.value = '';
            });

            // Обратный отсчет перед перенаправлением на страницу входа
            let i = 3;
            let interval = setInterval(function () {
                document.querySelector('.error').innerHTML = 'You will be redirected to the login page in ' + i + ' seconds';
                i--;
                if (i < 0) {
                    clearInterval(interval); // Останавливаем интервал
                    window.location.href = '/'; // Перенаправляем на страницу входа
                }
            }, 1000);
        })
        .catch((error) => {
            UserService.deletePreloader();
            // Проверяем, что error.errors существует
            if (error.errors) {
                // Если существует, собираем все ошибки в массив
                const allErrors = Object.values(error.errors).flat();

                // Проверяем количество ошибок
                if (allErrors.length === 1) {
                    // Если ошибка одна, выводим её
                    document.querySelector('.error').innerHTML = allErrors[0];
                } else {
                    // Если ошибок больше, выводим общее сообщение
                    document.querySelector('.error').innerHTML = "Check the data you entered";
                }
            } else {
                // Если error.errors не существует, выводим общее сообщение об ошибке
                document.querySelector('.error').innerHTML = "An unexpected error occurred";
            }
        });
}


