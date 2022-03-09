'use strict';

$(function () {
  var isArray = Array.isArray;
  var table = LaravelDataTables.dataTableBuilder;
  var isFirstTimeFiltering = true;

  var queryString = _.template('<%= key %>=<%= value %>&');

  function filter() {
    var inputs = document.getElementsByClassName('js-filter');
    inputs = _(inputs).filter(function (input) {
      return ['radio', 'checkbox'].includes(input.type) ? input.checked : true;
    });

    var filters = inputs.reduce(function (filters, filter) {
      if (!filter.value.length || filter.disabled) {
        return filters;
      }

      if (filter.multiple) {
        filters[filter.name] = $(filter).val();

        return filters;
      }

      filters[filter.name] = filter.value;

      return filters;
    }, {});

    if (!_.values(filters).filter(Boolean).length && isFirstTimeFiltering) {
      return true;
    }

    var url = location.pathname + '?' + _.map(filters, function (value, key) {
      if (isArray(value)) {
        return value.map(function (value) {
          return queryString({
            value: value,
            key: key
          });
        }).join('');
      }

      return queryString({
        value: value,
        key: key
      });
    }).join('');

    table.ajax.url(url);
    table.draw();
    history.replaceState({}, '', url);
    isFirstTimeFiltering = false;
  }

  $body.on('change', '.js-filter', function (event) {
    if (event.currentTarget.disabled) {
      return true;
    }
    filter();
  });
});
