"use strict";

let tsw_ajax_url;
let tsw_interval_id;
let tsw_status = 'stopped';
let tsw_datatables;
let tsw_quantity_per_batch;
let tsw_time_between_batches;
let tsw_max_secs_allowed;
let tsw_total_secs_executed;

jQuery(function () {
    console.log('Loading The SEO Workspace view..');

    if (typeof weAreInTheSeoWorkspace !== 'undefined') {
        tsw_ajax_url = jQuery('#tsw_form').data('tsw_ajax_url');
    }

    jQuery('body').on('click', '.tsw-wrap a[href="#"]', function (e) {
        e.preventDefault();
    });

    jQuery('body').on('click', '.tsw-btn-see-results', function () {
        window.open('/wp-admin/tools.php?page=the-seo-machine', '_blank');
    });

    jQuery('body').on('click', '.tsw-btn-study-site', function () {
        if (tsw_status == 'stopped') {
            tswStudySite();
        } else {
            tswStopAll();
        }
    });

    jQuery('body').on('click', '#tsw-btn-reset-queue-of-site', tswResetQueueOfSite);
    jQuery('body').on('click', '#tsw-btn-remove-data-of-site', tswRemoveDataOfSite);

    tswLoadDatatables();
    tswUpdateStatusBar();
});

function tswStudySite() {
    console.log('Starting study site..');
    jQuery('#tsw-btn-study-site').html('Stop');
    jQuery('#tsw-btn-study-site').addClass('tsw-button-studying');

    tsw_quantity_per_batch = jQuery('#quantity_per_batch').val();
    tsw_time_between_batches = jQuery('#time_between_batches').val();
    tsw_max_secs_allowed = jQuery('#tsw-current-selected-max_secs_allowed').val();
    console.log('Quantity per batch: ' + tsw_quantity_per_batch + ', time between batches: ' + tsw_time_between_batches);

    tsw_total_secs_executed = 0;
    tsw_interval_id = setInterval(tswStudySiteSendAjax, tsw_time_between_batches * 1000);
    tsw_status = 'studying';
}

function tswStudySiteSendAjax() {
    tsw_total_secs_executed += parseInt(tsw_time_between_batches);

    if (tsw_total_secs_executed < tsw_max_secs_allowed) {
        jQuery('#tsw-box-study-site-status').html('Doing batch..');

        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function (response) {
            if (xhr.readyState === 4) {
                jQuery('#tsw-box-study-site-status').html('Studying with current status: <strong>' + xhr.responseText + '</strong>');
                tswUpdateStatusBar();
                if (xhr.responseText.includes('finished')) {
                    tswStopAll();
                }
            }
        }

        xhr.open('POST', tsw_ajax_url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=tsw_do_batch&site-id=' + jQuery('#tsw-current-selected-id').val());
    } else {
        jQuery('#tsw-box-study-site-status').html('Studying with current status: <strong>finished, max secs achieved</strong>');
        tswStopAll();
        tswUpdateStatusBar();
    }
}

function tswUpdateStatusBar() {
    if (jQuery('#tsw-current-selected-id')) {
        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function (response) {
            if (xhr.readyState === 4) {
                let num_urls_in_queue = xhr.responseText.split(',')[0];
                let num_urls_in_queue_visited = xhr.responseText.split(',')[1];
                let num_urls = xhr.responseText.split(',')[2];

                jQuery('#tsw-progress-queue-text').html(num_urls_in_queue_visited
                    + ' URLs studied from the queue out of a total of ' + num_urls_in_queue + ' URLs enqueued');
                jQuery('#tsw-progress-queue-content').css('width', (num_urls_in_queue_visited * 100 / num_urls_in_queue) + '%');
            }
        }

        xhr.open('POST', tsw_ajax_url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=tsw_get_status&site-id=' + jQuery('#tsw-current-selected-id').val());
    }
}

function tswStopAll() {
    clearInterval(tsw_interval_id);
    jQuery('#tsw-btn-study-site').html('Study Site');
    jQuery('#tsw-btn-study-site').removeClass('tsw-button-studying');
    tsw_status = 'stopped';
}

function tswLoadDatatables() {
    jQuery('#tsw-datatable tfoot th.filterme').each(function () {
        let title = jQuery(this).text();

        jQuery(this).html('<input type="text" placeholder="Filter.." />');
    })

    tsw_datatables = jQuery('#tsw-datatable').DataTable({
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
            {
                'name': 'actions',
                'targets': 3,
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

function tswResetQueueOfSite() {
    jQuery.ajax({
        method: 'POST',
        url: tsw_ajax_url,
        data: {
            'action': 'tsw_reset_queue_of_site',
            'site-id': jQuery('#tsw-current-selected-id').val()
        },
        success: function(data) {
            console.log('Reset queue of site returned: ' + data);
            tswUpdateStatusBar();
        }
    });
}

function tswRemoveDataOfSite() {
    jQuery.ajax({
        method: 'POST',
        url: tsw_ajax_url,
        data: {
            'action': 'tsw_remove_data_of_site',
            'site-id': jQuery('#tsw-current-selected-id').val()
        },
        success: function(data) {
            console.log('Remove data of site returned: ' + data);
            tswUpdateStatusBar();
        }
    });
}