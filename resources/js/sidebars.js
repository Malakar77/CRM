document.addEventListener('DOMContentLoaded', (e)=>{


    document.getElementById('filterIcon').addEventListener('click', function (e) {

        let dropdownContent = document.getElementById('dropdownContent');

        dropdownContent.classList.toggle('show');

    });

    wi();
})


function wi()
{
    const apiKey = '0cb5678273b94faba6d183512252602'; // Замените на ваш API ключ
    const city = 'Москва'; // Город, для которого нужно получить данные о погоде
    const url = `http://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${city}&lang=ru`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);

            // Обработка данных о погоде
            const location = data.location.name;
            const temp = data.current.temp_c;

            document.getElementById('wi').innerHTML = `
            <div style="width: 70%;margin: 0 auto; display: flex; justify-content: center; align-items: center;">
                <img src="${data.current.condition.icon}" alt="">
                ${temp}°C
                <i class="bi bi-thermometer"></i>
            </div>
            `;
            console.log(`Текущая температура в ${location}: ${temp}°C`);
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
}

