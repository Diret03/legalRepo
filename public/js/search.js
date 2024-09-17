function searchTable(inputId, tableId) {
    let input = document.getElementById(inputId);
    let filter = input.value.toUpperCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName('tr');

    // Obtener la fila th
    let thRow = table.getElementsByTagName('thead')[0].getElementsByTagName('tr')[0];

    for (let i = 0; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let containsFilter = false;

        // Excluir la fila th del filtrado
        if (tr[i] === thRow) {
            continue;
        }

        for (let j = 0; j < td.length; j++) {
            let cellValue = td[j].textContent || td[j].innerText;
            if (cellValue.toUpperCase().indexOf(filter) > -1) {
                containsFilter = true;
                break;
            }
        }

        if (containsFilter) {
            tr[i].style.display = '';
        } else {
            tr[i].style.display = 'none';
        }
    }
}
