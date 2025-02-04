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
