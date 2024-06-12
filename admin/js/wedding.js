    $(function() {
        //editables 
        $('#brideName').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            },
            type: 'text',
            pk: 1,
            name: 'bride_name',
            title: 'Bride Name'
        });
        $('#firstname').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            }
        });
        $('#sex').editable({
            prepend: "not selected",
            source: [{
                value: 1,
                text: 'Male'
            }, {
                value: 2,
                text: 'Female'
            }],
            display: function(value, sourceData) {
                var colors = {
                        "": "#98a6ad",
                        1: "#5fbeaa",
                        2: "#5d9cec"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });
                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });
        $('#status').editable();
        $('#group').editable({
            showbuttons: false
        });
        $('#bdob').editable();
        $('#comments').editable({
            showbuttons: 'bottom'
        });
        //inline
        $('#inline-brideName').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            },
            type: 'text',
            pk: 1,
            name: 'bride_name',
            title: 'Bride Name',
            mode: 'inline'
        });
        $('#inline-firstname').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            },
            mode: 'inline'
        });
        $('#inline-sex').editable({
            prepend: "not selected",
            mode: 'inline',
            source: [{
                value: 1,
                text: 'Male'
            }, {
                value: 2,
                text: 'Female'
            }],
            display: function(value, sourceData) {
                var colors = {
                        "": "#98a6ad",
                        1: "#5fbeaa",
                        2: "#5d9cec"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });
                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });
        $('#inline-status').editable({
            mode: 'inline'
        });
        $('#inline-group').editable({
            showbuttons: false,
            mode: 'inline'
        });
        $('#inline-bdob').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            },
            mode: 'inline'
        });
        $('#inline-comments').editable({
            showbuttons: 'bottom',
            mode: 'inline'
        });    
    });
