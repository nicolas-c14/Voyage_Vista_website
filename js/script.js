function searchBar() {
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