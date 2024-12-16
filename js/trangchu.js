document.addEventListener('DOMContentLoaded', () => {
    // Smooth scroll to sections
    document.querySelectorAll('.sub-nav a').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const section = document.querySelector(`[data-section="${link.textContent.trim()}"]`);
            if (section) {
                window.scrollTo({
                    top: section.offsetTop - 120, // Adjust offset for fixed header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    const sections = document.querySelectorAll('.section');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();

        sections.forEach(section => {
            const items = section.querySelectorAll('.item');
            let sectionHasMatch = false;

            items.forEach(item => {
                const name = item.querySelector('.info h3').textContent.toLowerCase();
                if (name.includes(query)) {
                    item.style.display = '';
                    sectionHasMatch = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Hide section if no items match
            section.style.display = sectionHasMatch ? '' : 'none';
        });
    });
});