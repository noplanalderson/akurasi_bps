

var start = moment().startOf('month');
var end = moment().endOf('month');

$('#range').daterangepicker({
    startDate: start,
    endDate: end,
    "locale": {
        "cancelLabel": 'Clear',
        "format": "YYYY-MM-DD",
    },
    ranges: {
       '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
       '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
       '3 Bulan Terakhir': [moment().subtract(92, 'days'), moment()],
       'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
       'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
});

let tableHistoryCfg =  {
    responsive: true,
    processing: true,
    serverSide: true,
    "language": {
        "paginate": {
            "previous": "<i class='fas fa-chevron-left'></i>",
            "next": "<i class='fas fa-chevron-right'></i>",
        },
    },
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, 'All'] ],
    'columnDefs': [
        {
            "targets": 'no-sort',
            "orderable": false,
        },
        {
            'targets': [0,1,2,3],
            'class': "fs-13",
        }
    ],
    buttons: [
    {
        text: '<i class="fas fa-sync"></i> Reload',
        className: 'btn btn-info btn-sm py-1 px-2 fs-11',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload(function ( json ) { 
                $('meta[name="X-CSRF-TOKEN"]').attr('content', json.token);
            }, false);
        }
    }],
    dom: '<"float-start"lB><"float-end"fr>ti<"float-end"p>',
    "ajax": {
        "url": baseURI + 'login-history',
        "method": "POST",
        "data": function ( d ) {
            var range = $('#range').val().split(' - ');

            d.startDate = range[0];
            d.endDate = range[1];
            d.csrf_token = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        },
        "complete": function(res) {
            var res = res.responseJSON;
            $('input[name="csrf_token"]').val(res.token);
            $('meta[name="X-CSRF-TOKEN"]').attr('content', res.token);
            if(res.error !== null) {
                Toast.fire({
                    type : 'error',
                    icon: 'error',
                    title: '',
                    text: res.error,
                });
            }
        }
    },
    "columns":[
        { "data": "timestamp", "name": "timestamp", "title": "Waktu", "type": "datetime" },
        { "data": "ip_address", "name": "ip_address", "title": "Alamat IP" },
        { "data": "browser", "name": "browser", "title": "Browser" },
        { "data": "platform", "name": "platform", "title": "Platform" }
    ],
    initComplete: function(row, type, val, meta) {
        $('input[name="csrf_token"]').val(type.token);
        $('meta[name="X-CSRF-TOKEN"]').attr('content', type.token);
        if(type.error !== null) {
            Toast.fire({
                type : 'error',
                icon: 'error',
                title: '',
                text: type.error,
            }).replace( /(<([^>]+)>)/ig, '');
        }
    }
};


tableHistory = $('#tbl_login_history').DataTable(tableHistoryCfg);

$('#range').on('change', function () {  
    tableHistory.draw();
})