function ajaxGet(url, callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log('responseText:' + xmlhttp.responseText);
            try {
                var data = JSON.parse(xmlhttp.responseText);
            } catch (err) {
                console.log(err.message + " in " + xmlhttp.responseText);
                return;
            }
            callback(data);
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
function sortSelectOptions(lb) { 
    arr = new Array(); 
    for(i = 0; i < lb.length; i++) { 
        arr[i] = lb.options[i]; 
    } 
    arr.sort(function(a,b) {
        return (a.text > b.text)? 1 : ((a.text < b.text)? -1 : 0);
    });
    for(i = 0; i < lb.length; i++) { 
        lb.options[i] = arr[i];
    }
}
function updateAddFilter() {
    const field = document.querySelector('.addFilter [name="field"]');
    const operator = document.querySelector('.addFilter [name="operator"]');
    const value = document.querySelector('.addFilter [name="value"]');
    const values = document.querySelector('.addFilter [name="values"]');
    if (field.options[field.selectedIndex].dataset.references) {
        operator.style.display = 'none';
        value.type = 'hidden';
        values.style.display = 'inline';
        ajaxGet('values/' + field.value, function (data) {
            values.innerHTML = '';
            Object.keys(data).forEach(function (item) {
                var option = document.createElement('option');
                option.value = item;
                option.innerHTML = data[item];
                values.appendChild(option);
            });
            sortSelectOptions(values);
        });
    } else {
        operator.style.display = 'inline';
        value.type = 'text';
        values.style.display = 'none';
    }
}
function updateTextAndValue() {
    const text = document.querySelector('.addFilter [name="text"]');
    const value = document.querySelector('.addFilter [name="value"]');
    const values = document.querySelector('.addFilter [name="values"]');
    textArray = [];
    valueArray = [];
    for (var i = 0; i < values.options.length; i++) {
        const item = values.options[i];
        if (item.selected) {
            textArray.push(item.text);
            valueArray.push(item.value);
        }
    }
    text.value = textArray.join(', ');
    value.value = valueArray.join(',');
}

function closeFilter(index) {
    const elements = document.querySelectorAll('.filterbar');
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].dataset.index == index) {
            elements[i].parentNode.removeChild(elements[i]);
        }
    }
    return reloadQuery();
}
function editFilter(index) {
    const elements = document.querySelectorAll('.filterbar');
    var type = '';
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].dataset.index == index) {
            var filter = elements[i].dataset.filter;
            type = filter.substr(0, filter.indexOf(","));
            elements[i].parentNode.removeChild(elements[i]);
        }
    }
    if (type == "search") {
        // hide all
        // show search
        // fill form
    } else if (type == "value") {
        // hide all
        // show filter
        // fill form
    } else if (type == "reference") {
        // hide all
        // show filter
        // fill form
    }
    return false;
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
window.addEventListener('load', function () { hideColumns(); updateAddFilter(); });
window.addEventListener('resize', function () { resizeWindow(); });
