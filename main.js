// scripts.js
$(document).ready(function () {
    // Charger les achats existants depuis la base de données
    loadPurchases();

    // Gérer l'ajout d'un nouvel achat
    $('#addPurchaseForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'add_purchase.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#addPurchaseForm')[0].reset();
                loadPurchases();
            }
        });
    });

    // Filtrage de la table par recherche
    $('#searchInput').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('#purchasesBody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

// Fonction pour charger les achats
function loadPurchases() {
    $.ajax({
        url: 'fetch_purchases.php',
        type: 'GET',
        success: function (data) {
            $('#purchasesBody').html(data);
        }
    });
}

// Fonction pour trier le tableau
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("purchasesTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
