document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const nextButton = document.querySelector('.next');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');
    const mainContainer = document.querySelector('.main');
    // Initially hide all pages
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.style.display = 'none');

    // Show the current page
    const currentPageElement = document.querySelector('.page' + currentPage);
    if (currentPageElement) {
        currentPageElement.style.display = 'block';
    }

    // Adjust button visibility based on the current page
    if (currentPage === 4) {
        doneButton.style.display = 'block';
        nextButton.style.display = 'none';
    } else {
        doneButton.style.display = 'none';
        nextButton.style.display = 'block';
    }

    // Restore values
    form.querySelectorAll('input, select, textarea').forEach(input => {
        const storedValue = localStorage.getItem(input.name);
        if (storedValue) {
            input.value = storedValue;
        }

        input.addEventListener('input', () => {
            localStorage.setItem(input.name, input.value);
        });
    });

   // Back arrow functionality
   const backArrow = document.createElement('i');
    backArrow.className = 'bx bx-arrow-back back-arrow';
    document.querySelector('.main')?.appendChild(backArrow);
    
    if (currentPage === 1) backArrow.style.display = 'none';

    backArrow.addEventListener('click', () => {
        if (currentPage > 1) {
            localStorage.setItem('currentPage', currentPage - 1);
            window.location.href = `index.php?page=${currentPage - 1}`;
        }
    });

    // Back arrow functionality
    nextButton.addEventListener('click', (event) => {
        window.location.href = `index.php?page=${currentPage + 1}`;
    });

    // Done button functionality
    doneButton.addEventListener('click', (event) => {
        // You might want to submit the form here to process the data on the server

        // Show the output display and hide the pages
        //outputDisplay.style.display = 'block';
        //window.location.href = 'output.php';
        //pages.forEach(page => page.style.display = 'none');
        //doneButton.style.display = 'none';
        //backArrow.style.display = 'none';
    });


    // Civil Status Handling
    function updateStatusDisplay() {
        if (civilStatusSelect.value === 'Others') {
            otherStatusInput.style.display = 'inline-block';
            civilStatusSelect.style.width = '200px';
        } else {
            otherStatusInput.style.display = 'none';
            civilStatusSelect.style.width = '';
        }
    }

    // Initial setup for Civil Status
    updateStatusDisplay();

    // Event listener for Civil Status change
    civilStatusSelect.addEventListener('change', updateStatusDisplay);
});
