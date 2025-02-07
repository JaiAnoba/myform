document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const nextButton = document.querySelector('.next');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');
    const outputDisplays = document.querySelectorAll('.output_display');
    const mainSection = document.querySelector('.main');

    // Show the current page only
    for (let i = 1; i <= 4; i++) {
        let pageElement = document.querySelector('.page' + i);
        if (pageElement) {
            pageElement.style.display = (i === currentPage) ? 'block' : 'none';
        }
    }

    // Show or hide the .done button and .next button based on the current page
    if (currentPage === 4) {
        doneButton.style.display = 'block';
        nextButton.style.display = 'none';
    } else {
        doneButton.style.display = 'none';
        nextButton.style.display = 'block';
    }

    nextButton.addEventListener('click', (event) => {
        // If the page has validation errors, allow navigation, but show errors
        if (validatePage() || currentPage === 4) {
            window.location.href = `index.php?page=${currentPage + 1}`;
        } else {
            event.preventDefault();
        }
    });

    // Civil Status Toggle Logic
    if (civilStatusSelect && otherStatusInput) {
        otherStatusInput.style.display = 'none';

        civilStatusSelect.addEventListener('change', () => {
            if (civilStatusSelect.value === 'Others') {
                civilStatusSelect.style.display = 'none';
                otherStatusInput.style.display = 'inline-block';
                otherStatusInput.focus();
            }
        });
    }

    // Create the back arrow
    const backArrow = document.createElement('i');
    backArrow.className = 'bx bx-arrow-back back-arrow';

    // Append it inside .main
    const mainContainer = document.querySelector('.main');
    if (mainContainer) {
        mainContainer.appendChild(backArrow);
    }

    // Hide the arrow if on the first page
    if (currentPage === 1) {
        backArrow.style.display = 'none';
    }

    // Functionality to go back
    backArrow.addEventListener('click', () => {
        if (currentPage > 1) {
            window.location.href = `index.php?page=${currentPage - 1}`;
        }
    });

    // Initially hide all .output_display elements
    outputDisplays.forEach(display => {
        display.style.display = 'none';
    });

    // Show .output_display elements when the done button is clicked
    if (doneButton) {
        doneButton.addEventListener('click', (event) => {
            event.preventDefault(); 
            mainSection.style.display = 'none'; 
            outputDisplays.forEach(display => {
                display.style.display = 'block'; 
            });
        });
    }
});