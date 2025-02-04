import { UserService } from './script';
// import { exitUser } from './script';

document.addEventListener("DOMContentLoaded", () => {

    UserService.getUserData().then(userData => {
        addMenu(userData);
    });

    UserService.initExitUser();

})

function addMenu(user)
{
    let admin = user;
    fetch('/json/menu.json')
        .then(response => response.json())
        .then(data => {

            const menuContainer = document.querySelector('.list-unstyled');

            // Функция для создания элемента меню
            function createMenuItem(item)
            {
                const menuItem = document.createElement('li');
                if (item.items) {
                    menuItem.innerHTML = `
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#${item.title.toLowerCase()}-collapse" aria-expanded="false">
                            ${item.icon}&nbsp; ${item.title}
                        </button>
                        <div class="collapse" id="${item.title.toLowerCase()}-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                ${item.items.map(subItem => {
                                    if (admin.admin === true || subItem.user !== true) {
                                        return `<li class="editMenuLi"><a href="${subItem.href}" class="link-body-emphasis d-inline-flex text-decoration-none rounded">${subItem.title}</a></li>`;
                                    } else {
                                        return '';
                                    }
                                }).join('')}
                            </ul>
                        </div>
                        `;
                } else {
                    menuItem.innerHTML = `
                        <a href="${item.href}" class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed">
                            ${item.icon}&nbsp; ${item.title}
                        </a>

                        <i class="bi bi-pencil editMenu"></i>
                    `;
                }
                return menuItem;
            }

            // Функция для добавления пунктов меню
            function addMenuItems(menuItems, container)
            {
                menuItems.forEach(item => {
                    const menuItem = createMenuItem(item);
                    container.appendChild(menuItem);
                });
            }

            // Добавление основного меню
            addMenuItems(data, menuContainer);

        })
        .catch(error => console.error('Error loading menu data:', error));
}



