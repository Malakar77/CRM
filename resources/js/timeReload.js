
class CursorMonitor {
    constructor(checkInterval = 3600000) { // Интервал проверки по умолчанию 1 час
        this.cursorMoved = false; // Флаг для отслеживания движения курсора
        this.checkInterval = checkInterval; // Интервал проверки
        this.cursorCheckIntervalId = null; // ID интервала для очистки
        this.init();
    }

    // Инициализация
    init() {
        document.addEventListener("mousemove", this.checkCursorMovement.bind(this)); // Привязываем контекст
        this.startCursorCheck();
    }

    // Функция для проверки движения курсора
    checkCursorMovement() {
        this.cursorMoved = true; // Устанавливаем флаг, если курсор движется
    }


    // Запускаем проверку движения курсора через определённый интервал времени
    startCursorCheck() {
        this.cursorCheckIntervalId = setInterval(() => {
            if (!this.cursorMoved) {
                // Если курсор не двигался, выполняем функцию удаления куков и обновления страницы
                this.deleteCookiesAndReload();
            }

            this.cursorMoved = false; // Сбрасываем флаг после каждой проверки
        }, this.checkInterval);
    }

    // Функция для удаления куков и обновления страницы
    async deleteCookiesAndReload() {
        try {
            const response = await fetch('/api/logout',{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            window.location.href = '/';
        } catch (error) {
            console.error('Error logging out:', error);
        }
    }

    // Остановка проверки курсора
    stop() {
        clearInterval(this.cursorCheckIntervalId); // Очищаем интервал
        document.removeEventListener("mousemove", this.checkCursorMovement.bind(this)); // Удаляем слушатель
    }
}

// Создаем экземпляр класса
const cursorMonitor = new CursorMonitor();
