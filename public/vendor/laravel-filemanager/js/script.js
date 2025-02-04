import {Client, Service} from "../../../../resources/js/class/client.js";

// Определяем переменные
var lfm_route = location.origin + location.pathname; // Сохраняем путь к текущему URL
var show_list; // Переменная для хранения списка (не используется в коде)
var sort_type = 'alphabetic'; // Стандартный тип сортировки (по алфавиту)
var multi_selection_enabled = false; // Флаг для включения многовыборов
var selected = []; // Массив для хранения выбранных элементов
var items = []; // Массив для хранения элементов

// jQuery плагин для создания плавающего кнопочного меню (FAB)
$.fn.fab = function (options) {
    var menu = this; // Ссылаемся на элемент, к которому применяется плагин
    menu.addClass('fab-wrapper'); // Добавляем класс для стилизации контейнера

    // Создаем кнопку-тогглер (кнопка для открытия/закрытия меню)
    var toggler = $('<a>')
        .addClass('fab-button fab-toggle') // Добавляем классы для стилизации
        .append($('<i>').addClass('fas fa-plus')) // Добавляем иконку "плюс"
        .click(function () {
            // При клике на кнопку toggle, добавляем/удаляем класс для анимации меню
            menu.toggleClass('fab-expand');
        });

    menu.append(toggler); // Добавляем кнопку в меню

    // Перебираем кнопки, переданные в параметре options
    options.buttons.forEach(function (button) {
        // Для каждой кнопки добавляем новый элемент меню
        toggler.before(
            $('<a>').addClass('fab-button fab-action') // Кнопка действия
                .attr('data-label', button.label) // Атрибут с меткой для кнопки
                .attr('id', button.attrs.id) // Устанавливаем id для кнопки
                .append($('<i>').addClass(button.icon)) // Добавляем иконку
                .click(function () {
                    // При клике на кнопку убираем класс для закрытия меню
                    menu.removeClass('fab-expand');
                })
        );
    });
};


$(document).ready(function () {
    $('#fab').fab({
        buttons: [
        {
            icon: 'fas fa-upload',
            label: lang['nav-upload'],
            attrs: {id: 'upload'}
        },
        {
            icon: 'fas fa-folder',
            label: lang['nav-new'],
            attrs: {id: 'add-folder'}
        }
        ]
    });

    actions.reverse().forEach(function (action) {
        $('#nav-buttons > ul').prepend(
            $('<li>').addClass('nav-item').append(
                $('<a>').addClass('nav-link d-none')
                .attr('data-action', action.name)
                .attr('data-multiple', action.multiple)
                .append($('<i>').addClass('fas fa-fw fa-' + action.icon))
                .append($('<span>').text(action.label))
            )
        );
    });

    sortings.forEach(function (sort) {
        $('#nav-buttons .dropdown-menu').append(
            $('<a>').addClass('dropdown-item').attr('data-sortby', sort.by)
            .append($('<i>').addClass('fas fa-fw fa-' + sort.icon))
            .append($('<span>').text(sort.label))
            .click(function () {
                sort_type = sort.by;
                loadItems();
            })
        );
    });

    loadFolders();
    performLfmRequest('errors')
    .done(function (response) {
        JSON.parse(response).forEach(function (message) {
            $('#alerts').append(
                $('<div>').addClass('alert alert-warning')
                .append($('<i>').addClass('fas fa-exclamation-circle'))
                .append(' ' + message)
            );
        });
    });

    $(window).on('dragenter', function () {
        $('#uploadModal').modal('show');
    });

    if (usingWysiwygEditor()) {
        $('#multi_selection_toggle').hide();
    }
});

// ======================
// ==  Navbar actions  ==
// ======================

$('#multi_selection_toggle').click(function () {
    multi_selection_enabled = !multi_selection_enabled;

    $('#multi_selection_toggle i')
    .toggleClass('fa-times', multi_selection_enabled)
    .toggleClass('fa-check-double', !multi_selection_enabled);

    if (!multi_selection_enabled) {
        clearSelected();
    }
});

$('#to-previous').click(function () {
    var previous_dir = getPreviousDir();
    if (previous_dir == '') {
        return;
    }
    goTo(previous_dir);
});

function toggleMobileTree(should_display)
{
    if (should_display === undefined) {
        should_display = !$('#tree').hasClass('in');
    }
    $('#tree').toggleClass('in', should_display);
}

$('#show_tree').click(function (e) {
    toggleMobileTree();
});

$('#main').click(function (e) {
    if ($('#tree').hasClass('in')) {
        toggleMobileTree(false);
    }
});

$(document).on('click', '#add-folder', function () {
    dialog(lang['message-name'], '', createFolder);
});

$(document).on('click', '#upload', function () {
    $('#uploadModal').modal('show');
});

$(document).on('click', '[data-display]', function () {
    show_list = $(this).data('display');
    loadItems();
});

$(document).on('click', '[data-action]', function () {
    window[$(this).data('action')]($(this).data('multiple') ? getSelectedItems() : getOneSelectedElement());
});

// ==========================
// ==  Multiple Selection  ==
// ==========================

function toggleSelected(e)
{
    if (!multi_selection_enabled) {
        selected = [];
    }

    var sequence = $(e.target).closest('a').data('id');
    var element_index = selected.indexOf(sequence);
    if (element_index === -1) {
        selected.push(sequence);
    } else {
        selected.splice(element_index, 1);
    }

    updateSelectedStyle();
}

function clearSelected()
{
    selected = [];

    multi_selection_enabled = false;

    updateSelectedStyle();
}

function updateSelectedStyle()
{
    items.forEach(function (item, index) {
        $('[data-id=' + index + ']')
        .find('.square')
        .toggleClass('selected', selected.indexOf(index) > -1);
    });
    toggleActions();
}

function getOneSelectedElement(orderOfItem)
{
    var index = orderOfItem !== undefined ? orderOfItem : selected[0];
    return items[index];
}

function getSelectedItems()
{
    return selected.reduce(function (arr_objects, id) {
        arr_objects.push(getOneSelectedElement(id));
        return arr_objects
    }, []);
}

function toggleActions()
{
    var one_selected = selected.length === 1;
    var many_selected = selected.length >= 1;
    var only_image = getSelectedItems()
    .filter(function (item) {
        return !item.is_image; })
    .length === 0;
    var only_file = getSelectedItems()
    .filter(function (item) {
        return !item.is_file; })
    .length === 0;

    $('[data-action=use]').toggleClass('d-none', !(many_selected && only_file));
    $('[data-action=rename]').toggleClass('d-none', !one_selected);
    $('[data-action=preview]').toggleClass('d-none', !(many_selected && only_file));
    $('[data-action=move]').toggleClass('d-none', !many_selected);
    $('[data-action=download]').toggleClass('d-none', !(many_selected && only_file));
    $('[data-action=resize]').toggleClass('d-none', !(one_selected && only_image));
    $('[data-action=crop]').toggleClass('d-none', !(one_selected && only_image));
    $('[data-action=trash]').toggleClass('d-none', !many_selected);
    $('[data-action=open]').toggleClass('d-none', !one_selected || only_file);
    $('#multi_selection_toggle').toggleClass('d-none', usingWysiwygEditor() || !many_selected);
    $('#actions').toggleClass('d-none', selected.length === 0);
    $('#fab').toggleClass('d-none', selected.length !== 0);
}

// ======================
// ==  Folder actions  ==
// ======================

$(document).on('click', '#tree a', function (e) {
    goTo($(e.target).closest('a').data('path'));
    toggleMobileTree(false);
});

function goTo(new_dir)
{
    $('#working_dir').val(new_dir);
    loadItems();
}

function getPreviousDir()
{
    var working_dir = $('#working_dir').val();
    return working_dir.substring(0, working_dir.lastIndexOf('/'));
}

function setOpenFolders()
{
    $('#tree [data-path]').each(function (index, folder) {
      // close folders that are not parent
        var should_open = ($('#working_dir').val() + '/').startsWith($(folder).data('path') + '/');
        $(folder).children('i')
        .toggleClass('fa-folder-open', should_open)
        .toggleClass('fa-folder', !should_open);
    });

    $('#tree .nav-item').removeClass('active');
    $('#tree [data-path="' + $('#working_dir').val() + '"]').parent('.nav-item').addClass('active');
}

// ====================
// ==  Ajax actions  ==
// ====================

function performLfmRequest(url, parameter, type)
{
    var data = defaultParameters();

    if (parameter != null) {
        $.each(parameter, function (key, value) {
            data[key] = value;
        });
    }

    return $.ajax({
        type: 'GET',
        beforeSend: function (request) {
            var token = getUrlParam('token');
            if (token !== null) {
                request.setRequestHeader("Authorization", 'Bearer ' + token);
            }
        },
        dataType: type || 'text',
        url: lfm_route + '/' + url,
        data: data,
        cache: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        displayErrorResponse(jqXHR);
    });
}

function displayErrorResponse(jqXHR)
{
    var message = JSON.parse(jqXHR.responseText)
    if (Array.isArray(message)) {
        message = message.join('<br>')
    }
    notify('<div style="max-height:50vh;overflow: auto;">' + message + '</div>');
}

var refreshFoldersAndItems = function (data) {
    loadFolders();

    if (data !== 'OK') {
        data = Array.isArray(data) ? data.join('<br/>') : data;
        notify(data);
    }



};

var hideNavAndShowEditor = function (data) {
    $('#nav-buttons > ul').addClass('d-none');
    $('#content').html(data);
    $('#pagination').removeClass('preserve_actions_space')
    clearSelected();
}

function loadFolders()
{
    performLfmRequest('folders', {}, 'html')
    .done(function (data) {
        $('#tree').html(data);
        loadItems();

    });
}

function generatePaginationHTML(el, args)
{
    var template = '<li class="page-item"><\/li>';
    var linkTemplate = '<a class="page-link"><\/a>';
    var currentPage = args.currentPage;
    var totalPage = args.totalPage;
    var rangeStart = args.rangeStart;
    var rangeEnd = args.rangeEnd;
    var i;

  // Disable page range, display all the pages
    if (args.pageRange === null) {
        for (i = 1; i <= totalPage; i++) {
            var button = $(template)
            .attr('data-num', i)
            .append($(linkTemplate).html(i));
            if (i == currentPage) {
                button.addClass('active');
            }
            el.append(button);
        }

        return;
    }

    if (rangeStart <= 3) {
        for (i = 1; i < rangeStart; i++) {
            var button = $(template)
            .attr('data-num', i)
            .append($(linkTemplate).html(i));
            if (i == currentPage) {
                button.addClass('active');
            }
            el.append(button);
        }
    } else {
        var button = $(template)
        .attr('data-num', 1)
        .append($(linkTemplate).html(1));
        el.append(button);

        var button = $(template)
        .addClass('disabled')
        .append($(linkTemplate).html('...'));
        el.append(button);
    }

    for (i = rangeStart; i <= rangeEnd; i++) {
        var button = $(template)
        .attr('data-num', i)
        .append($(linkTemplate).html(i));
        if (i == currentPage) {
            button.addClass('active');
        }
        el.append(button);
    }

    if (rangeEnd >= totalPage - 2) {
        for (i = rangeEnd + 1; i <= totalPage; i++) {
            var button = $(template)
            .attr('data-num', i)
            .append($(linkTemplate).html(i));
            el.append(button);
        }
    } else {
        var button = $(template)
        .addClass('disabled')
        .append($(linkTemplate).html('...'));
        el.append(button);

        var button = $(template)
        .attr('data-num', totalPage)
        .append($(linkTemplate).html(totalPage));
        el.append(button);
    }
}

function createPagination(paginationSetting)
{
    var el = $('<ul class="pagination" role="navigation"></ul>');

    var currentPage = paginationSetting.current_page;
    var pageRange = 5;
    var totalPage = Math.ceil(paginationSetting.total / paginationSetting.per_page);

    var rangeStart = currentPage - pageRange;
    var rangeEnd = currentPage + pageRange;

    if (rangeEnd > totalPage) {
        rangeEnd = totalPage;
        rangeStart = totalPage - pageRange * 2;
        rangeStart = rangeStart < 1 ? 1 : rangeStart;
    }

    if (rangeStart <= 1) {
        rangeStart = 1;
        rangeEnd = Math.min(pageRange * 2 + 1, totalPage);
    }

    generatePaginationHTML(el, {
        totalPage: totalPage,
        currentPage: currentPage,
        pageRange: pageRange,
        rangeStart: rangeStart,
        rangeEnd: rangeEnd
    });

    $('#pagination').append(el);
}

function loadItems(page)
{
    loading(true);
    performLfmRequest('jsonitems', {show_list: show_list, sort_type: sort_type, page: page || 1}, 'html')
    .done(function (data) {
        selected = [];
        var response = JSON.parse(data);
        var working_dir = response.working_dir;
        items = response.items;
        var hasItems = items.length !== 0;
        var hasPaginator = !!response.paginator;
        $('#empty').toggleClass('d-none', hasItems);
        $('#content').html('').removeAttr('class');
        $('#pagination').html('').removeAttr('class');

        if (hasItems) {
            $('#content').addClass(response.display);
            $('#pagination').addClass('preserve_actions_space');

            items.forEach(function (item, index) {
                var template = $('#item-template').clone()
                .removeAttr('id class')
                .attr('data-id', index)
                .click(toggleSelected)
                .dblclick(function (e) {
                    if (item.is_file) {
                        use(getSelectedItems());
                    } else {
                        goTo(item.url);
                    }
                });

                if (item.thumb_url) {
                    var image = $('<div>').css('background-image', 'url("' + item.thumb_url + '?timestamp=' + item.time + '")');
                } else {
                    var icon = $('<div>').addClass('ico');
                    var image = $('<div>').addClass('mime-icon ico-' + item.icon).append(icon);
                }

                template.find('.square').append(image);
                template.find('.item_name').text(item.name);
                template.find('time').text((new Date(item.time * 1000)).toLocaleString());

                $('#content').append(template);
            });
        }

        if (hasPaginator) {
            createPagination(response.paginator);

            $('#pagination a').on('click', function (event) {
                event.preventDefault();

                loadItems($(this).closest('li')[0].getAttribute('data-num'));

                return false;
            });
        }

        $('#nav-buttons > ul').removeClass('d-none');

        $('#working_dir').val(working_dir);
        console.log('Current working_dir : ' + working_dir);
        var breadcrumbs = [];
        var validSegments = working_dir.split('/').filter(function (e) {
            return e; });
        validSegments.forEach(function (segment, index) {
            if (index === 0) {
              // set root folder name as the first breadcrumb
                breadcrumbs.push($("[data-path='/" + segment + "']").text());
            } else {
                breadcrumbs.push(segment);
            }
        });

        $('#current_folder').text(breadcrumbs[breadcrumbs.length - 1]);
        $('#breadcrumbs > ol').html('');
        breadcrumbs.forEach(function (breadcrumb, index) {
            var li = $('<li>').addClass('breadcrumb-item').text(breadcrumb);

            if (index === breadcrumbs.length - 1) {
                li.addClass('active').attr('aria-current', 'page');
            } else {
                li.click(function () {
                  // go to corresponding path
                    goTo('/' + validSegments.slice(0, 1 + index).join('/'));
                });
            }

            $('#breadcrumbs > ol').append(li);
        });

        var atRootFolder = getPreviousDir() == '';
        $('#to-previous').toggleClass('d-none invisible-lg', atRootFolder);
        $('#show_tree').toggleClass('d-none', !atRootFolder).toggleClass('d-block', atRootFolder);
        setOpenFolders();
        loading(false);
        toggleActions();
    });
}

function loading(show_loading)
{
    $('#loading').toggleClass('d-none', !show_loading);
}

function createFolder(folder_name)
{
    performLfmRequest('newfolder', {name: folder_name})
    .done(refreshFoldersAndItems);
}

// ==================================
// ==         File Actions         ==
// ==================================

// Функция для переименования файла или папки
function rename(item)
{
    // Открываем диалог для ввода нового имени
    dialog(lang['message-rename'], item.name, function (new_name) {
        // Отправляем запрос на переименование с текущим и новым именем
        performLfmRequest('rename', {
            file: item.name,
            new_name: new_name
        }).done(refreshFoldersAndItems); // После успешного выполнения обновляем папки и элементы
    });
}

// Функция для перемещения элементов в корзину (удаления)
function trash(items)
{
    // Показываем подтверждение для удаления
    confirm(lang['message-delete'], function () {
        // Отправляем запрос на удаление элементов
        performLfmRequest('delete', {
            items: items.map(function (item) {
                return item.name; // Отправляем массив имен удаляемых элементов
            })
        }).done(refreshFoldersAndItems); // После успешного выполнения обновляем папки и элементы
    });
}

// Функция для обрезки изображения
function crop(item)
{
    // Отправляем запрос на обрезку изображения
    performLfmRequest('crop', {img: item.name})
        .done(hideNavAndShowEditor); // После успешного выполнения скрываем навигацию и показываем редактор
}

// Функция для изменения размера изображения
function resize(item)
{
    // Отправляем запрос на изменение размера изображения
    performLfmRequest('resize', {img: item.name})
        .done(hideNavAndShowEditor); // После успешного выполнения скрываем навигацию и показываем редактор
}

// Функция для скачивания выбранных элементов
function download(items)
{
    // Для каждого элемента создаем отдельный запрос на скачивание
    items.forEach(function (item, index) {
        // Получаем параметры по умолчанию
        var data = defaultParameters();

        // Добавляем имя файла в параметры запроса
        data['file'] = item.name;

        // Если в URL есть параметр 'token', добавляем его к запросу
        var token = getUrlParam('token');
        if (token) {
            data['token'] = token;
        }

        // Ожидаем перед скачиванием, чтобы избежать параллельных запросов
        setTimeout(function () {
            // Перенаправляем на URL для скачивания с параметрами
            location.href = lfm_route + '/download?' + $.param(data);
        }, index * 100); // Множим на индекс, чтобы сделать задержку для каждого элемента
    });
}

// Функция для открытия элемента (например, изображения или документа)
function open(item)
{
    // Переходим по URL элемента
    goTo(item.url);
}

function preview(items)
{
    // Клонируем шаблон карусели и подготавливаем его для предпросмотра
    var carousel = $('#carouselTemplate').clone()
        .attr('id', 'previewCarousel')  // Задаем новый ID для карусели предпросмотра
        .removeClass('d-none');  // Делаем карусель видимой, убирая класс 'd-none'

    // Клонируем шаблоны отдельных элементов карусели и индикаторов
    var imageTemplate = carousel.find('.carousel-item').clone().removeClass('active');
    var indicatorTemplate = carousel.find('.carousel-indicators > li').clone().removeClass('active');

    // Очищаем содержимое карусели перед добавлением новых элементов
    carousel.children('.carousel-inner').html('');
    carousel.children('.carousel-indicators').html('');

    // Переключаем видимость элементов управления навигацией (prev, next) и индикаторов в зависимости от количества элементов
    carousel.children('.carousel-indicators, .carousel-control-prev, .carousel-control-next').toggle(items.length > 1);

    // Проходим по всем элементам и генерируем элементы карусели и индикаторы
    items.forEach(function (item, index) {
        // Клонируем новый элемент карусели, делаем его активным, если это первый элемент
        var carouselItem = imageTemplate.clone()
            .addClass(index === 0 ? 'active' : '');  // Делаем первый элемент активным

        // Проверяем, является ли файл PDF
        if (item.url.endsWith('.pdf')) {
            // Если это PDF, добавляем ссылку, которая откроет весь файл в новой вкладке
            var carouselItem = imageTemplate.clone()
                .addClass(index === 0 ? 'active' : '');  // Делаем первый элемент активным

            carouselItem.find('.carousel-label').attr('target', '_blank')  // Открывать PDF в новой вкладке
                .attr('href', item.url)  // Устанавливаем URL файла
                .text(item.name)  // Устанавливаем имя элемента
                .append($('<i class="fas fa-external-link-alt ml-2"></i>'));  // Добавляем иконку внешней ссылки

            carousel.children('.carousel-inner').append(carouselItem);

            // Создаем индикаторы и другие элементы карусели, как обычно
            var carouselIndicator = indicatorTemplate.clone()
                .addClass(index === 0 ? 'active' : '')  // Делаем первый индикатор активным
                .attr('data-slide-to', index);  // Устанавливаем индекс для индикатора
            carousel.children('.carousel-indicators').append(carouselIndicator);
        } else if (item.thumb_url) {
            // Если это изображение, отображаем его как фоновое изображение
            carouselItem.find('.carousel-image').css('background-image', 'url(\'' + item.url + '?timestamp=' + item.time + '\')');
        } else {
            // Если это не изображение и не PDF, отображаем иконку MIME-типов
            carouselItem.find('.carousel-image').css('width', '50vh')
                .append($('<div>').addClass('mime-icon ico-' + item.icon));
        }

        // Устанавливаем ссылку для метки элемента карусели
        carouselItem.find('.carousel-label').attr('target', '_blank')  // Открывать ссылку в новой вкладке
            .attr('href', item.url)  // Устанавливаем URL
            .text(item.name)  // Устанавливаем имя элемента
            .append($('<i class="fas fa-external-link-alt ml-2"></i>'));  // Добавляем иконку внешней ссылки

        // Добавляем элемент карусели в секцию .carousel-inner
        carousel.children('.carousel-inner').append(carouselItem);

        // Создаем и настраиваем индикатор для карусели
        var carouselIndicator = indicatorTemplate.clone()
            .addClass(index === 0 ? 'active' : '')  // Делаем первый индикатор активным
            .attr('data-slide-to', index);  // Устанавливаем индекс для индикатора
        carousel.children('.carousel-indicators').append(carouselIndicator);
    });

    // Обработка событий прикосновения для управления свайпом на мобильных устройствах
    var touchStartX = null;

    // Захватываем начальную позицию прикосновения, когда пользователь начинает свайп
    carousel.on('touchstart', function (event) {
        var e = event.originalEvent;
        if (e.touches.length == 1) {
            var touch = e.touches[0];
            touchStartX = touch.pageX;
        }
    }).on('touchmove', function (event) {
        var e = event.originalEvent;
        if (touchStartX != null) {
            var touchCurrentX = e.changedTouches[0].pageX;

            // Если расстояние свайпа больше 60px, переходим к предыдущему или следующему слайду
            if ((touchCurrentX - touchStartX) > 60) {
                touchStartX = null;
                carousel.carousel('prev');  // Свайп влево (переход к предыдущему слайду)
            } else if ((touchStartX - touchCurrentX) > 60) {
                touchStartX = null;
                carousel.carousel('next');  // Свайп вправо (переход к следующему слайду)
            }
        }
    }).on('touchend', function () {
        touchStartX = null;  // Сбрасываем touchStartX, когда прикосновение заканчивается
    });

    // Уведомляем о созданной карусели (предположительно, это кастомная функция для инициализации или отслеживания)
    notify(carousel);
}

// Функция для перемещения элементов. Отправляет запрос с их именами на сервер
function move(items)
{
    // Выполняем запрос 'move' и передаем массив имен элементов
    performLfmRequest('move', { items: items.map(function (item) {
            return item.name; }) })
        .done(refreshFoldersAndItems); // После выполнения запроса обновляем папки и элементы
}

// Функция для получения значения параметра из URL
function getUrlParam(paramName)
{
    // Создаем регулярное выражение для поиска параметра в строке запроса
    var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
    var match = window.location.search.match(reParam); // Ищем совпадение в строке запроса
    return ( match && match.length > 1 ) ? match[1] : null; // Возвращаем значение параметра или null
}

// Функция для обработки выбранных элементов (например, для вставки URL в редактор)
function use(items)
{
    // Функция для использования TinyMCE 3 для вставки изображения
    function useTinymce3(url)
    {
        if (!usingTinymce3()) {
            return; // Если не используется TinyMCE 3, выходим из функции
        }

        // Получаем ссылку на окно редактора
        var win = tinyMCEPopup.getWindowArg("window");
        // Вставляем URL в поле ввода
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = url;

        // Если существует диалог с изображением, обновляем данные изображения
        if (typeof(win.ImageDialog) != "undefined") {
            if (win.ImageDialog.getImageData) {
                win.ImageDialog.getImageData();
            }
            if (win.ImageDialog.showPreviewImage) {
                win.ImageDialog.showPreviewImage(url);
            }
        }

        // Закрываем модальное окно
        tinyMCEPopup.close();
    }

    // Функция для использования TinyMCE 4 с Colorbox для вставки URL
    function useTinymce4AndColorbox(url)
    {
        if (!usingTinymce4AndColorbox()) {
            return; // Если не используется TinyMCE 4 с Colorbox, выходим из функции
        }

        // Вставляем URL в поле ввода в родительском окне
        parent.document.getElementById(getUrlParam('field_name')).value = url;

        // Если TinyMCE используется в родительском окне, закрываем окно редактора
        if (typeof parent.tinyMCE !== "undefined") {
            parent.tinyMCE.activeEditor.windowManager.close();
        }

        // Если используется Colorbox, закрываем его
        if (typeof parent.$.fn.colorbox !== "undefined") {
            parent.$.fn.colorbox.close();
        }
    }

    // Функция для использования TinyMCE 5 для вставки URL
    function useTinymce5(url)
    {
        if (!usingTinymce5()) {
            return; // Если не используется TinyMCE 5, выходим из функции
        }

        // Отправляем сообщение родительскому окну для вставки контента
        parent.postMessage({
            mceAction: 'insert',
            content: url
        });

        // Закрываем окно редактора
        parent.postMessage({ mceAction: 'close' });
    }

    // Функция для использования CKEditor 3 для вставки изображения
    function useCkeditor3(url)
    {
        if (!usingCkeditor3()) {
            return; // Если не используется CKEditor 3, выходим из функции
        }

        // Вставляем изображение в CKEditor через окно или родительский iframe
        if (window.opener) {
            // Popup окно
            window.opener.CKEDITOR.tools.callFunction(getUrlParam('CKEditorFuncNum'), url);
        } else {
            // Вставка в modal-окно (iframe)
            parent.CKEDITOR.tools.callFunction(getUrlParam('CKEditorFuncNum'), url);
            parent.CKEDITOR.tools.callFunction(getUrlParam('CKEditorCleanUpFuncNum'));
        }
    }

    // Функция для использования FCKeditor 2 для вставки изображения
    function useFckeditor2(url)
    {
        if (!usingFckeditor2()) {
            return; // Если не используется FCKeditor 2, выходим из функции
        }

        var p = url;
        var w = data['Properties']['Width'];
        var h = data['Properties']['Height'];

        // Вставляем изображение с его размерами
        window.opener.SetUrl(p, w, h);
    }

    // Получаем URL первого элемента в списке
    var url = items[0].url;
    // Получаем параметр callback из URL, если он есть
    var callback = getUrlParam('callback');
    var useFileSucceeded = true;

    // Проверяем, используется ли один из WYSIWYG редакторов
    if (usingWysiwygEditor()) {
        useTinymce3(url);          // Используем TinyMCE 3
        useTinymce4AndColorbox(url); // Используем TinyMCE 4 с Colorbox
        useTinymce5(url);          // Используем TinyMCE 5
        useCkeditor3(url);         // Используем CKEditor 3
        useFckeditor2(url);        // Используем FCKeditor 2
    } else if (callback && window[callback]) {
        // Если есть callback, вызываем его в текущем окне
        window[callback](getSelectedItems());
    } else if (callback && parent[callback]) {
        // Если есть callback, вызываем его в родительском окне
        parent[callback](getSelectedItems());
    } else if (window.opener) {
        // В случае standalone-кнопки или других ситуаций
        window.opener.SetUrl(getSelectedItems());
    } else {
        useFileSucceeded = false; // Если ни один редактор не найден, ставим флаг неудачи
    }

    // Если операция успешна, закрываем окно
    if (useFileSucceeded) {
        if (window.opener) {
            window.close();
        }
    } else {
        console.log('window.opener not found');
        // Если редактор не найден, открываем файл с использованием стандартного метода браузера
        window.open(url);
    }
}

//end useFile

// ==================================
// ==     WYSIWYG Editors Check    ==
// ==================================

// Функция проверяет, используется ли TinyMCE 3, проверяя наличие объекта 'tinyMCEPopup' в глобальном объекте 'window'
function usingTinymce3()
{
    return !!window.tinyMCEPopup;
}

// Функция проверяет, используется ли TinyMCE 4 с Colorbox, проверяя параметр 'field_name' в URL
function usingTinymce4AndColorbox()
{
    return !!getUrlParam('field_name');
}

// Функция проверяет, используется ли TinyMCE 5, проверяя параметр 'editor' в URL
function usingTinymce5()
{
    return !!getUrlParam('editor');
}

// Функция проверяет, используется ли CKEditor 3, проверяя параметры 'CKEditor' или 'CKEditorCleanUpFuncNum' в URL
function usingCkeditor3()
{
    return !!getUrlParam('CKEditor') || !!getUrlParam('CKEditorCleanUpFuncNum');
}

// Функция проверяет, используется ли FCKeditor 2, проверяя объект 'window.opener' и параметры 'data'
function usingFckeditor2()
{
    return window.opener && typeof data != 'undefined' && data['Properties']['Width'] != '';
}

// Функция проверяет, используется ли один из популярных WYSIWYG редакторов (TinyMCE 3/4/5, CKEditor 3, FCKeditor 2)
function usingWysiwygEditor()
{
    // Проверяем, используется ли любой из перечисленных редакторов
    return usingTinymce3() || usingTinymce4AndColorbox() || usingTinymce5() || usingCkeditor3() || usingFckeditor2();
}


// ==================================
// ==            Others            ==
// ==================================

// Функция возвращает объект с параметрами из формы
function defaultParameters()
{
    return {
        // Получаем значение поля с id 'working_dir'
        working_dir: $('#working_dir').val(),

        // Получаем значение поля с id 'type'
        type: $('#type').val()
    };
}

// Функция для уведомления пользователя, что функция еще не реализована
function notImp()
{
    // Показываем уведомление с текстом 'Not yet implemented!'
    notify('Not yet implemented!');
}

// Функция для показа уведомлений в модальном окне
function notify(body)
{
    // Открываем модальное окно с id 'notify' и вставляем текст в тело модала
    $('#notify').modal('show').find('.modal-body').html(body);
}

// Функция для отображения модального окна подтверждения с кнопкой и обратным вызовом
function confirm(body, callback)
{
    // Если обратный вызов передан, показываем кнопку подтверждения
    $('#confirm').find('.btn-primary').toggle(callback !== undefined);

    // При клике на кнопку выполняем переданный callback
    $('#confirm').find('.btn-primary').click(callback);

    // Показываем модальное окно и вставляем текст в его тело
    $('#confirm').modal('show').find('.modal-body').html(body);
}

// Функция для отображения диалогового окна с полем ввода
function dialog(title, value, callback)
{
    // Устанавливаем начальное значение в поле ввода
    $('#dialog').find('input').val(value);

    // При показе модального окна фокусируемся на поле ввода
    $('#dialog').on('shown.bs.modal', function () {
        $('#dialog').find('input').focus();
    });

    // Обрабатываем клик по кнопке подтверждения и вызываем callback с введенным значением
    $('#dialog').find('.btn-primary').unbind().click(function (e) {
        callback($('#dialog').find('input').val());
    });

    // Показываем модальное окно и устанавливаем заголовок
    $('#dialog').modal('show').find('.modal-title').text(title);
}


