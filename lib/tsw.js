"use strict";

let tsw_ajax_url;

(function ($) {
    $(document).ready(function () {
        console.log('Loading The SEO Workspace view..');

        if (typeof weAreInTheSeoWorkspace !== 'undefined') {
            tsw_ajax_url = document.getElementById('tsw_form').dataset.tsw_ajax_url;
        }

        $('body').on('click', '.tsw-wrap a[href="#"]', function (e) {
            e.preventDefault();
        });

        tswLoadDatatables();
    });

    function tswLoadDatatables() {
        $('#tsw-datatable tfoot th.filterme').each(function () {
            let title = $(this).text();

            $(this).html('<input type="text" placeholder="Filter.." />');
        })

        let tsw_datatables = $('#tsw-datatable').DataTable({
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
                {
                    'name': 'actions',
                    'targets': 5,
                    'data': null,
                    'defaultContent': 'Show Edit',
                    'render': function (data, type, row, meta) {
                        return '<a href="?page=the-seo-workspace&select-id=' + data[0] + '" class="button button-green tsw-btn-select-item">Select</a>' +
                            '<a href="?page=the-seo-workspace&edit-id=' + data[0] + '" class="button button-green tsw-btn-edit-item">Edit</a>';
                    }
                }
            ],
            aLengthMenu: [[10, 25, 50, 100, 500, 1000, 2000, 5000, 10000, -1], [10, 25, 50, 100, 500, 1000, 2000, 5000, 10000, "All"]]
        });

        console.log('Loaded The SEO Workspace view!');
    }
})(jQuery);
