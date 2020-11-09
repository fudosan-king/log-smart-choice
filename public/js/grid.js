class GridData {
    constructor(id, checkboxClass, selectAll, jsClass) {
        this.id = id;
        this.checkboxClass = checkboxClass;
        this.data = [];
        this.selectAll = selectAll;
        this.jsClass = jsClass;
        this.selectAll.bind('click', this, this.checkAll);
        $(this.checkboxClass).bind('change', this, this.onRowChange);
        $(this.jsClass).bind('change', this, this.onFieldChange);
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
                string.push(key + '=' + value);
            }
            serialize_string.push(string.join(','));
        }
        $('input[name="serialize_data"]').val(btoa(serialize_string.join('&')));
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
}

var Grid = new GridData('form-search', '.row_id', $('#select_all'), '.js_serialize_fields');