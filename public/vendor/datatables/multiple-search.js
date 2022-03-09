var multipleSearch = function(columns = '{}') {
    $("[data-toggle='tooltip']").tooltip();

    var api = this.api();

    // oculta as colunas de busca, respeitando a visibilidade da coluna
    api.on('responsive-resize', hideSearchColumn);

    // insere uma linha no thead da tabela com a classe filter_container
    $(document.createElement("tr")).addClass('filter_container')
        .appendTo($(api.columns().header()).parent().parent());

    api.columns().every(function(column, index, array){ attachSearchField.call(this, api, columns)});
}

function attachSearchField(api, columns) {
    let column = this;

    let th = document.createElement("th");
    $(th).addClass('sorting_disabled');

    let input = menageInputField(column, api, columns)

    $(th).append(input)
        .appendTo(`#${api.table().node().id} .filter_container`);

    if ($(column.header())[0].style.display == 'none') {
        $(th).hide();
    }

    delaySearchTimer = null;
    $(input).off('click keyup change search')
        .on('click keyup change search', function(){ searchColumnAction.call(this, column)});
}

function menageInputField(column, api, columns)
{
    if (!api.init().columns[column.index()].searchable) {
        return "";
    }

    let input = "";
    if (columns[api.init().columns[column.index()].data]) {
        if (columns[api.init().columns[column.index()].data].type === 'date') {
            input = document.createElement('input');
            input.setAttribute('type', 'date');
            $(input).addClass('form-control form-control-sm-f');

            return input;
        }

        input = document.createElement("select");
        $(input).addClass('form-control form-control-sm-f');
        $(input).append(document.createElement("option"));

        columns[api.init().columns[column.index()].data].data.map(function(item) {
            option = document.createElement("option");
            option.append(item.description);
            option.value = item.value;
            input.appendChild(option);
        });

        return input;
    }

    input = document.createElement("input");
    $(input).addClass('form-control form-control-sm')
        .attr('type', 'search')
        .prop('placeholder', $(column.header()).prop('title'));

    return input;
}

function searchColumnAction(column) {
    if (column.search() == $(this).val()) {
        return;
    }
    column.search($(this).val(), false, false, true).draw();
}

function hideSearchColumn(e, datatable, columns) {
    let th = $(`#${datatable.table().node().id} .filter_container th`);

    for (let i = 0; i < columns.length; i++) {
        if (columns[i]) {
            $(th[i]).show();
        } else {
            $(th[i]).hide();
        }
    }
}
