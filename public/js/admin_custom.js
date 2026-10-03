$(document).ready(function() {
    $('table[id^="table"]').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json' },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        responsive: true,
        columnDefs: [
            { orderable: false, targets: 'no-sort' } // class="no-sort" sur th pour désactiver le tri
        ]
    });
});
