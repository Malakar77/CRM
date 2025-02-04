document.addEventListener('DOMContentLoaded', (e)=>{
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('clock').textContent = hours +':'+minutes +':'+seconds;
    }

    setInterval(updateClock, 1000); // Обновляем каждую секунду
    updateClock();

    const today = new Date();
    const day = today.getDate();
    const monthNames = [
        "января", "февраля", "марта", "апреля", "мая", "июня",
        "июля", "августа", "сентября", "октября", "ноября", "декабря"
    ];
    const month = monthNames[today.getMonth()];
    const year = today.getFullYear();

    // Получаем форматированную дату с сегодняшней датой
    document.getElementById('date_block').innerText =  `${day} ${month} ${year} г`;
})
