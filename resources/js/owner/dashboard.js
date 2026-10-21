// Interaksi dashboard Owner yang aman untuk data contoh (tanpa database).
document.addEventListener('DOMContentLoaded', () => {
    if (!document.body.classList.contains('owner-page')) return;
  
    document.querySelectorAll('.owner-disabled-link').forEach((link) => {
      link.addEventListener('click', (event) => event.preventDefault());
    });
  
    const search = document.getElementById('ownerOrderSearch');
    const table = document.getElementById('ownerOrdersTable');
    if (search && table) {
      search.addEventListener('input', () => {
        const query = search.value.trim().toLocaleLowerCase('id-ID');
        table.querySelectorAll('tbody tr').forEach((row) => {
          row.classList.toggle('owner-hidden-row', !row.textContent.toLocaleLowerCase('id-ID').includes(query));
        });
      });
    }
  
    const exportButton = document.getElementById('ownerExportCsv');
    if (exportButton && table) {
      exportButton.addEventListener('click', () => {
        const csv = Array.from(table.querySelectorAll('tr')).map((row) => {
          const cells = Array.from(row.querySelectorAll('th,td'));
          // Kolom "Aksi" tidak termasuk CSV
          return cells.slice(0, -1).map((cell) => '"' + cell.innerText.trim().replace(/\s+/g, ' ').replace(/"/g, '""') + '"').join(',');
        }).join('\r\n');
        const blob = new Blob(['\uFEFF', csv], {type:'text/csv;charset=utf-8'});
        const url = URL.createObjectURL(blob);
        const anchor = document.createElement('a');
        anchor.href = url;
        anchor.download = 'presma-owner-orders-demo.csv';
        document.body.appendChild(anchor);
        anchor.click();
        anchor.remove();
        URL.revokeObjectURL(url);
      });
    }
  });
  