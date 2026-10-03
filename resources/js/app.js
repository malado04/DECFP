/**
 * ======================================================================
 * 🌐 Application principale (Laravel + Vite + AdminLTE)
 * ======================================================================
 */

// ⚙️ Dépendances de base
import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

// 🧱 Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';

// 🎨 AdminLTE
import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js';

// 📊 Chart.js (graphiques)
import Chart from 'chart.js/auto';
window.Chart = Chart;

// 📑 DataTables
import 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

// 🔔 SweetAlert2 (alertes modernes)
import Swal from 'sweetalert2';
window.Swal = Swal;

// 🖼️ Import automatique d’images et polices (optionnel)
import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

// =====================================================================
// 🚀 Scripts d’interface
// =====================================================================

// Exemple : initialisation automatique des DataTables
document.addEventListener('DOMContentLoaded', () => {
    if ($('.table').length > 0) {
        $('.table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json'
            }
        });
    }

    // Exemple : afficher une alerte de succès
    if (window.successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: window.successMessage,
            confirmButtonColor: '#3085d6'
        });
    }

    // Exemple : alerte de confirmation (suppression)
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
