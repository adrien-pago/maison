// scripts.js
$(document).ready(function () {
    // Charger les achats existants depuis la base de données
    loadPurchases();
    loadMagasins();

    // Gérer l'ajout d'un nouvel achat
    $('#addPurchaseForm').on('submit', function (e) {
        e.preventDefault(); // Empêcher le rechargement de la page

        let formData = $(this).serializeArray(); // Récupérer les données du formulaire

        // Gérer l'ajout d'un nouveau magasin
        if ($('#magasin').val() === 'new') {
            formData.push({ name: 'newMagasin', value: $('#newMagasin').val() });
        }

        $.ajax({
            url: 'add_purchase.php',
            type: 'POST',
            data: formData,
            success: function () {
                $('#addPurchaseForm')[0].reset(); // Réinitialiser le formulaire après l'ajout
                $('#newMagasinContainer').hide(); // Masquer le champ "nouveau magasin"
                $('#magasin').show(); // Réafficher la combo box
                loadPurchases(); // Recharger les données pour mettre à jour les tableaux
                loadMagasins();  // Recharger la liste des magasins
            }
        });
    });

    // Filtrage de la table par recherche
    $('#searchInput').on('keyup', function () {
        var value = $(this).val().toLowerCase(); // Récupérer la valeur de recherche
        $('#purchasesBody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); // Afficher/Masquer les lignes correspondantes
        });
    });

    // Exporter le tableau en Excel
    $('#exportExcel').on('click', function () {
        window.location.href = 'export_excel.php'; // Redirection vers l'exportation Excel
    });

    // Gérer l'affichage du champ de nouveau magasin
    $('#magasin').on('change', function () {
        if ($(this).val() === 'new') {
            $('#magasin').hide();
            $('#newMagasinContainer').show();
        } else {
            $('#newMagasinContainer').hide();
        }
    });

    // Valider le nouveau magasin
    $('#confirmNewMagasin').on('click', function () {
        var newMagasin = $('#newMagasin').val();
        if (newMagasin.trim() !== '') {
            $.ajax({
                url: 'add_purchase.php',
                type: 'POST',
                data: { action: 'addMagasin', name: newMagasin },
                success: function (response) {
                    loadMagasins(); // Recharger la liste des magasins après ajout
                    $('#newMagasinContainer').hide();
                    $('#magasin').show();
                }
            });
        }
    });

    // Annuler l'ajout de nouveau magasin
    $('#cancelNewMagasin').on('click', function () {
        $('#newMagasinContainer').hide();
        $('#magasin').show();
    });
});

// Fonction pour charger les achats et les dépenses totales
function loadPurchases() {
    $.ajax({
        url: 'fetch_purchases.php',
        type: 'GET',
        success: function (data) {
            // Séparer les données de l'historique des achats et des dépenses totales
            var parts = data.split("||");
            $('#purchasesBody').html(parts[0]); // Historique des achats
            $('#totalExpensesBody').html(parts[1]); // Dépenses totales par acheteur

            // Calculer le total général des dépenses
            let grandTotal = 0;
            $('#totalExpensesBody tr').each(function () {
                grandTotal += parseFloat($(this).find('td:first').text().replace(' €', '').replace(',', '.'));
            });
            $('#grandTotal').text(grandTotal.toFixed(2) + ' €');
        }
    });
}

// Charger la liste des magasins
function loadMagasins() {
    $.ajax({
        url: 'fetch_magasins.php',
        type: 'GET',
        success: function (data) {
            $('#magasin').html('<option value="">Sélectionner un magasin</option><option value="new">Enregistrer un nouveau magasin</option>' + data);
        }
    });
}

// Fonction pour trier le tableau de l'historique des achats
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("purchasesTable");
    switching = true;
    dir = "asc"; // Direction initiale de tri
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

// Fonction pour supprimer un achat avec confirmation
function deletePurchase(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet achat ?")) {
        $.ajax({
            url: 'delete_purchase.php',
            type: 'POST',
            data: { id: id },
            success: function () {
                loadPurchases(); // Recharger les achats après suppression
            }
        });
    }
}
