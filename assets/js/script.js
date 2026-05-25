/* =========================
   DESTINATIONS
========================= */

<select id ="destinations">
    <option value="Paris">Paris</option>
    <option value="Londres">Londres</option>
    <option value="Barcelone">Barcelone</option>
    <option value="Rome">Rome</option>
    <option value="Tokyo">Tokyo</option>
    <option value="New York">New York</option>
</select>

/* =========================
   SEARCH FORM
========================= */

function initializeSearch() {

    const searchInput = document.getElementById('searchInput');
        const select = document.getElementById('destinations');
        const options = Array.from(select.options);

        searchInput.addEventListener('input', () => {
        const filter = searchInput.value.toLowerCase();
        select.innerHTML = ''; // Vide la liste
        options
            .filter(opt => opt.text.toLowerCase().includes(filter))
            .forEach(opt => select.appendChild(opt));
        });

}

/* =========================
   INIT
========================= */

document.addEventListener("DOMContentLoaded", function() {

    initializeSearch();

});
