document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');

    // Show the current page only
    for (let i = 1; i <= 4; i++) {
        let pageElement = document.querySelector('.page' + i);
        if (pageElement) {
            pageElement.style.display = (i === currentPage) ? 'block' : 'none';
        }
    }

    // Change button text on last page
    if (currentPage === 4 && doneButton) {
        doneButton.textContent = "Submit";
    }

    // Handle form submission
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Allow navigation through pages even if there are errors
        if (currentPage < 4) {
            window.location.href = `index.php?page=${currentPage + 1}`;
        } else {
            form.submit();  // On last page, submit the form
        }
    });

    // Hide output section if errors exist
    let outputSection = document.getElementById("display-container");
    if (outputSection && outputSection.getAttribute("data-show") !== "true") {
        outputSection.style.display = "none";
    }

    // Civil Status Toggle Logic
    if (civilStatusSelect && otherStatusInput) {
        // Initially hide the text field
        otherStatusInput.style.display = 'none';

        civilStatusSelect.addEventListener('change', () => {
            if (civilStatusSelect.value === 'Others') {
                civilStatusSelect.style.display = 'none';  // Hide select field
                otherStatusInput.style.display = 'inline-block';  // Show text field
                otherStatusInput.focus();  // Focus on text field
            }
        });
    }
});
