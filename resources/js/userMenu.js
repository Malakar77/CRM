import { UserService } from './script';
import * as bootstrap from 'bootstrap';
document.addEventListener('DOMContentLoaded', function () {

    /**
     * Данные об авторизованном пользователе
     */
    UserService.getUserData().then(user => {
        readJsonSettings(user);
    });


    document.addEventListener('click', (e) => {

        if (e.target.classList.contains('editMenu')) {
            menuOpen();
            removeElemEdit();

            UserService.getUserData().then(user => {
                addElemEdit(user);
            });

            let elem = document.querySelectorAll('.editMenu');
            elem.forEach(item => {
                item.classList.remove('editMenu');
                item.classList.add('open');
            });
            return;
        }

        if (e.target.classList.contains('open')) {
            menuClose();
            removeElemEdit();
            let elem = document.querySelectorAll('.open');
            elem.forEach(item => {
                item.classList.remove('open');
                item.classList.add('editMenu');
            });
            return;
        }

        if (e.target.classList.contains('bi-star')) {
            updateStarFull(e.target);
            return;
        }
        if (e.target.classList.contains('bi-star-fill')) {
            updateStar(e.target);
            return;
        }
    });
});


/**
 * функция открытия всего выпадающего списка категорий меню
 */
function menuOpen()
{
    let collapseToggleList = [].slice.call(document.querySelectorAll('.btn-toggle[data-bs-toggle="collapse"]'));
    collapseToggleList.forEach(function (collapseToggleEl) {
        let targetId = collapseToggleEl.getAttribute('data-bs-target');
        let targetEl = document.querySelector(targetId);
        let collapse = new bootstrap.Collapse(targetEl, {
            toggle: false
        });
        collapse.show();

    });
}
/**
 * функция закрытия всего выпадающего списка категорий меню
 */
function menuClose()
{
    let collapseToggleList = [].slice.call(document.querySelectorAll('.btn-toggle[data-bs-toggle="collapse"]'));
    collapseToggleList.forEach(function (collapseToggleEl) {
        let targetId = collapseToggleEl.getAttribute('data-bs-target');
        let targetEl = document.querySelector(targetId);
        let collapse = new bootstrap.Collapse(targetEl, {
            toggle: false
        });
        collapse.hide();

    });
}

/**
 * Функция добавления звездочек на все элементы
 */
function addElemEdit(variable)
{
    let prefix = variable.prefix;
    let user = decodeURIComponent(prefix);


    fetch(`/json/${user}.json`, { cache: "no-cache" })
        .then(response => response.json())
        .then(data => {
            let li = document.querySelectorAll('li.editMenuLi');
            li.forEach(item => {
                let a = item.querySelector('a');
                if (a) {
                    let title = a.innerHTML.trim();
                    if (data.some(obj => obj.title === title)) {
                        // Если есть совпадение, добавляем звезду-заполнитель
                        item.insertAdjacentHTML('beforeend', `
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" style="float: right; margin-top: 8px">
                                <path class="bi-star-fill" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                        `);
                    } else {
                        // Если нет совпадения, добавляем обычную звезду
                        item.insertAdjacentHTML('beforeend', `
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16" style="float: right; margin-top: 8px">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                            </svg>
                        `);
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading menu data:', error);
            let li = document.querySelectorAll('li.editMenuLi');
            li.forEach(item => {
                item.insertAdjacentHTML('beforeend', `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16" style="float: right; margin-top: 8px;">
                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                `);
            });
        });
}


/**
 * Функция удаления звездочек на все элементы
 */
function removeElemEdit()
{
    let svgElements = document.querySelectorAll('li.editMenuLi svg');
    svgElements.forEach(svg => {
        svg.remove();
    });
}

/**
 * Функция добавления в json файл
 * @param elem
 */
function updateStarFull(elem)
{
    let li = elem.closest('li.editMenuLi');
    li.querySelector('svg.bi-star').remove();
    li.insertAdjacentHTML('beforeend', `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" style="float: right; margin-top: 8px; ">
    <path class="bi-star-fill" d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
    </svg>
        `);

    fetch("/UserMenu", {
        method: "POST",
        contentType: "application/json",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            'title': li.querySelector('a').innerHTML,
            'href': li.querySelector('a').href,
            'add': true
        })
    })
        .then(response => response.json())
        .then(data => {
            addFavorites(data);
        })

}


/**
 * Функция удаления из json файл
 * @param elem
 */
function updateStar(elem)
{
    let li = elem.closest('li.editMenuLi');
    li.querySelector('svg.bi-star-fill').remove();
    li.insertAdjacentHTML('beforeend', `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16" style="float: right; margin-top: 8px;">
                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
            </svg>
        `);
    fetch("/UserMenu", {
        method: "POST",
        contentType: "application/json",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            'title' : li.querySelector('a').innerHTML,
            'remove' : true
        })
    })
        .then(response => response.json())
        .then(data => {
            removeFavorites(data);
        })

}


/**
 * Функция удаления прелоадера
 */
function deleteLoader()
{
    //если есть лоадер удаляем его
    if (document.querySelector('.loader')) {
        document.querySelector('.loader').remove();
    }
}

/**
 * Функция добавления позиций пользовательского меню на сайт
 * @param elem
 */
function addFavorites(elem)
{
    let div = document.querySelector('.favorites');
    let li = document.createElement('li');
    li.classList = 'mt-2 mb-2';
    li.innerHTML = `
    <a href="${elem.href}" class="link-body-emphasis d-inline-flex text-decoration-none rounded ms-3">${elem.title}</a>
    `;
    div.append(li);
}


/**
 * Функция удаления позиций пользовательского меню с сайта
 * @param elem
 */
function removeFavorites(elem)
{
    let div = document.querySelector('.favorites');
    let a = div.querySelectorAll('a');
    a.forEach(item=>{
        if (item.innerHTML === elem.title) {
            item.remove();
        }
    })
}

/**
 * Функция вывода пользовательского меню избранное
 * @param variable
 */
function readJsonSettings(variable)
{
    let prefix = variable.prefix;
    let user = decodeURIComponent(prefix);

    fetch("/readJsonSettings", {
        method: "POST",
        contentType: "application/json",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            'user' : variable.prefix
        })
    })
        .then(response => response.json())
        .then(data => {
            let block = document.querySelector('.favorites');
            for (let i = 0; i < data.length; i++) {
                let li = document.createElement('li');
                li.classList = 'mt-2 mb-2';

                li.innerHTML = `
                    <a href="${data[i].href}" class="link-body-emphasis d-inline-flex text-decoration-none rounded ms-3">${data[i].title}</a>
                `;
                block.append(li);
            }
        })
        .catch(error => console.error('Error loading menu data:', error));

}



