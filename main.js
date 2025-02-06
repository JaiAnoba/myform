document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer').getAttribute('data-page'));
    const doneButton = document.querySelector('.done');

    for (let i = 1; i <= 4; i++) {
        const page = document.querySelector('.page' + i);
        if (page) {
            page.style.display = (i === currentPage) ? 'block' : 'none';
        }
    }

    if (currentPage === 4) {
        doneButton.textContent = "Submit";
    }

    // Intercept form submission to update the URL and move to the next page
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        if (currentPage < 4) {
            const nextPage = currentPage + 1; // Increment page number
            window.location.href = `?page=${nextPage}`; // Update the URL
        } else {
            alert("Form submitted successfully!"); 
        }
    });
});
