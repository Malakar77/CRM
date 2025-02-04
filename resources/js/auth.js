document.addEventListener('click', (e) => {

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

        // Запускаем функцию для отправки данных на сервер
        authUser();
    }
});



function authUser(){

        // Очищаем предыдущее сообщение об ошибке
        document.querySelector('.error').innerHTML = ' ';

        // Сбор данных из формы
        const data = {
            login: document.querySelector('.login').value.trim(),
            password: document.querySelector('.pass').value.trim(),
        };

        // Отправка данных на сервер
        fetch('/api/auth-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                // Удаляем прелоадер после получения ответа
                deleteLoader();

                // Если статус ответа не в диапазоне 200-299, выбрасываем ошибку
                if (!response.ok) {
                    return response.json().then(err => { throw err });
                }

                // Возвращаем данные в формате JSON
                return response.json();
            })
            .then(data => {
                // Удаляем прелоадер, если всё прошло успешно
                deleteLoader();

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
                    document.querySelector('.error').innerHTML = 'Будете перенаправлены через ' + i + ' секунды';
                    i--;
                    if (i < 0) {
                        clearInterval(interval); // Останавливаем интервал
                        window.location.href = '/api/main'; // Перенаправляем на страницу входа
                    }
                }, 1000);
            })
            .catch((error) => {

                // Check if error.errors exists and is an object
                const allErrors = error.errors ? Object.values(error.errors).flat() : [];

                // Проверяем количество ошибок
                if (allErrors.length === 1) {
                    // Если ошибка одна, выводим её
                    document.querySelector('.error').innerHTML = allErrors[0];
                } else {
                    // Если ошибок больше, выводим общее сообщение
                    document.querySelector('.error').innerHTML = "Check the data you entered";
                }
            });

}


/**
 * Функция удаления прелоадера.
 * Проверяет наличие элемента с классом 'loader' и удаляет его,
 * а также убирает класс 'sent' у кнопки.
 */
function deleteLoader() {
    // Если есть прелоадер, удаляем его
    if (document.querySelector('.loader')) {
        document.querySelector('.loader').remove();
        document.querySelector('.glow-on-hover').classList.remove('sent');
    }
}
