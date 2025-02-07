document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const nextButton = document.querySelector('.next');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');

    // Show the current page only
    for (let i = 1; i <= 4; i++) {
        let pageElement = document.querySelector('.page' + i);
        if (pageElement) {
            pageElement.style.display = (i === currentPage) ? 'block' : 'none';
        }
    }

    if (currentPage === 4) {
        doneButton.style.display = 'block';
        nextButton.style.display = 'none';
    } else {
        doneButton.style.display = 'none';
        nextButton.style.display = 'block';
    }

    doneButton.addEventListener('click', (event) => {
        if (currentPage === 4) {
            // Submit the form when on page 4
            event.preventDefault(); 

            const mainContainer = document.querySelector('.main');
            const outputDisplay = document.querySelector('.OUTPUT_DISPLAY');
            
            if (mainContainer) {
                mainContainer.style.display = 'none'; 
            }

            if (outputDisplay) {
                outputDisplay.style.display = 'block'; 
            }
        }
    });

    nextButton.addEventListener('click', (event) => {
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
});
