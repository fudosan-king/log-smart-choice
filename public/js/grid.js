class GridData {
    constructor(id, checkboxClass, jsClass, selected, selectAll, ajaxUrl) {
        this.id = id;
        this.checkboxClass = checkboxClass;
        this.data = [];
        this.jsClass = jsClass;
        this.selectAll = selectAll;
        this.searchSelected = selected;
        this.ajaxUrl = ajaxUrl;
        this.init();
    }
    init() {
        const regex = 'group';
        var currentUrl = window.location.href;
        if (currentUrl.includes(regex)) {
            $(this.jsClass).prop('disabled', true);
        }
        $(this.checkboxClass).bind('change', this, this.onRowChange);
        $(this.jsClass).bind('change', this, this.onFieldChange);
        $(this.searchSelected).bind('change', this, this.onSelectedChange);
        $(this.selectAll).bind('change', this, this.checkAll);
        this.initData();
    }
    initData() {
        var data = window.atob($('input[name="serialize_data"]').val());
        if (data) {
            data = data.split('&');
            for (var index = 0; index < data.length; index++) {
                var row = JSON.parse(data[index]),
                    // inputName = 'input_' + row._id,
                    selectName = 'select_'+ row._id;
                for (const [key, value] of Object.entries(row)) {
                    // $('input[name="' + inputName + '_' + key + '"]').val(value);
                    $('select[name="' + selectName + '_' + key + '"] option[value="'+value +'"]').attr('selected','selected');
                }
                $('#row_' + row._id).find('input[name="row_id"]').prop('checked', true);
                this.setData(row);
            }
            $('input[name="row_id"]').trigger('change');
        }
    }
    setData(data) {
        var index = this.searchById(data._id);
        if (index !== false) {
            this.data[index] = data;
        } else {
            this.data.push(data);
        }
    }
    unsetData(id) {
        var index = this.searchById(id);
        if (index !== false) {
            this.data.splice(index, 1);
        }
    }
    searchById(id) {
        for (var index = 0; index < this.data.length; index++) {
            if (this.data[index]._id == id) {
                return index;
            }
        }
        return false;
    }
    serializeData() {
        var serialize_string = [];
        for (var index = 0; index < this.data.length; index++) {
            var string = [];
            for (const [key, value] of Object.entries(this.data[index])) {
                string.push('"' + key + '": "' + value +'"');
            }
            serialize_string.push('{' + string.join(',') + '}');
        }
        $('input[name="serialize_data"]').val(window.btoa(serialize_string.join('&')));
    }
    checkAll(event) {
        var checked = false,
            grid = event.data;
        if ($(this).prop('checked')) {
            checked = true;
        }
        $(grid.checkboxClass).each(function() {
            $(this).prop('checked', checked).trigger('change');
        })
    }
    onRowChange(event) {
        var grid = event.data,
            id = $(this).val(),
            serialize_fields = $(this).closest('tr').find(grid.jsClass);
        if ($(this).prop('checked')) {
            $(this).closest('tr').find(grid.jsClass).prop("disabled", false);
            var data = { '_id': id };
            serialize_fields.each(function() {
                data[$(this).data('name')] = $(this).val();
                grid.setData(data)
            })
        } else {
            $(this).closest('tr').find(grid.jsClass).prop("disabled", true);
            grid.unsetData(id);
        }
        grid.serializeData();
    }
    onFieldChange(event) {
        var grid = event.data;
        $(this).closest('tr').find(grid.checkboxClass).trigger('change');
    }
    onSelectedChange(event) {
        $('input[name="selected"]').val($(this).val());
    }
}