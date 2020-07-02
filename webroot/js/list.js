function closeFilter(index) {
    const elements = document.querySelectorAll('.filterbar');
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].dataset.index == index) {
            elements[i].parentNode.removeChild(elements[i]);
        }
    }
    return reloadQuery();
}
function navigatePage(page) {
    const element = document.querySelector('.pagination');
    if (element) {
        element.dataset.page = page;
    }
    return reloadQuery();
}
function isPartiallyOffscreen(element) {
    var rect = element.getBoundingClientRect();
    return rect.x < 0 || (rect.x + rect.width) > (window.innerWidth - 20);
}
var timeOut = null;
function resizeWindow() {
    if (timeOut != null) clearTimeout(timeOut);
    timeOut = setTimeout(hideColumns, 100);
}
function hideColumns() {
    const all = document.querySelectorAll('th, td');
    for (var i = 0; i < all.length; i++) {
        all[i].classList.remove('hidden');
    }
    const elements = document.querySelectorAll('th');
    var max = elements.length;
    for (var i = 0; i < elements.length; i++) {
        if (isPartiallyOffscreen(elements[i])) {
            max = i;
            break;
        }
    }
    const headers = document.querySelectorAll('th:nth-child(n+' + (max + 1) + ')');
    for (var i = 0; i < headers.length; i++) {
        headers[i].classList.add('hidden');
    }
    const cells = document.querySelectorAll('td:nth-child(n+' + (max + 1) + ')');
    for (var i = 0; i < cells.length; i++) {
        cells[i].classList.add('hidden');
    }
}
function reloadQuery() {
    const elements = document.querySelectorAll('.filterbar');
    var params = [];
    for (var i = 0; i < elements.length; i++) {
        params.push('filter=' + encodeURIComponent(elements[i].dataset.filter));
    }
    const element = document.querySelector('.pagination');
    if (element) {
        params.push('page=' + encodeURIComponent(element.dataset.page));
    }
    document.location.href = '?' + params.join('&');
    return false;
}
window.addEventListener('load', function () { hideColumns(); })
window.addEventListener('resize', function () { resizeWindow(); })
