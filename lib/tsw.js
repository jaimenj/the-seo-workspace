"use strict";

let tsw_ajax_url;

function tswOnLoadMain() {
    console.log('Loading The SEO Workspace view..');
    tswLoadDatatables();
}

function tswLoadDatatables() {
    jQuery('#tsw-datatable tfoot th.filterme').each(function () {
        let title = jQuery(this).text();

        jQuery(this).html('<input type="text" placeholder="Filter.." />');
    })

    let tsw_datatables = jQuery('#tsw-datatable').DataTable({
        dom: '<"float-left"i><"float-right"f>t<"float-left"l>B<"float-right"p><"clearfix">',
        responsive: true,
        order: [[0, "desc"]],
        buttons: ['csv', 'excel', 'pdf'],
        initComplete: function () {
            this.api().columns().every(function () {
                let that = this

                jQuery('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw()
                    }
                })
            })
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: tsw_ajax_url + '?action=tsw_urls',
            type: 'POST'
        },
        columnDefs: [
            { 'name': 'id', 'targets': 0 },
            { 'name': 'home_url', 'targets': 1 },
            { 'name': 'mainInfo', 'targets': 2 },
            { 'name': 'is_online', 'targets': 3 },
            { 'name': 'emails_to_notify', 'targets': 4 },
            { 'name': 'actions', 'targets': 5 }
        ],
        aLengthMenu: [[10, 25, 50, 100, 500, 1000, 2000, 5000, 10000, -1], [10, 25, 50, 100, 500, 1000, 2000, 5000, 10000, "All"]]
    });

    console.log('Loaded The SEO Workspace view!');
}

// Starts all JS..
window.addEventListener('load', () => {
    if (typeof weAreInTheSeoWorkspace !== 'undefined') {
        tsw_ajax_url = document.getElementById('tsw_form').dataset.tsw_ajax_url;

        tswOnLoadMain();
    }
});
