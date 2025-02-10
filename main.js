document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const currentPage = parseInt(document.getElementById('pageContainer')?.getAttribute('data-page') || "1");
    const doneButton = document.querySelector('.done');
    const nextButton = document.querySelector('.next');
    const civilStatusSelect = document.getElementById('civilStatus');
    const otherStatusInput = document.getElementById('otherStatus');
    const outputDisplay = document.querySelector('.OUTPUT_DISPLAY');
    const mainContainer = document.querySelector('.main');

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

    if (sessionStorage.getItem('showOutputDisplay') === 'true') {
        mainContainer.style.display = 'none';
        outputDisplay.style.display = 'block';
        displayUserData();
    }

    doneButton.addEventListener('click', (event) => {
        if (currentPage === 4) {
            event.preventDefault();
    
            const formData = new FormData(form);
    
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) 
            .then(data => {
                mainContainer.style.display = 'none';
                outputDisplay.style.display = 'block';
                displayUserData();
            })
            .catch(error => console.error('Error:', error));
        }
    });
    

    function displayUserData() {
        const formData = new FormData(form);
        const birthDate = new Date(formData.get('dob'));
        const today = new Date();
        const civilStatus = formData.get('civil_status');
        const otherStatus = formData.get('otherStatus');
        const age = today.getFullYear() - birthDate.getFullYear() - (today < new Date(today.getFullYear(), birthDate.getMonth(), birthDate.getDate()) ? 1 : 0);
        
        document.querySelector('.o_name').innerText = `${formData.get('last_name')}, ${formData.get('first_name')} ${formData.get('middle_name').charAt(0).toUpperCase()}.`;
        document.querySelector('.o_age').innerText = `${age}`;
        document.querySelector('.o_status').innerText = (civilStatus === 'Others' && otherStatus.trim() !== '') 
    ? otherStatus 
    : civilStatus;
        document.querySelector('.o_dob').innerText = formData.get('dob');
        document.querySelector('.o_sex').innerText = formData.get('gender');
        document.querySelector('.o_nationality').innerText = formData.get('nationality');
        document.querySelector('.o_religion').innerText = formData.get('religion');
        document.querySelector('.o_tin').innerText = formData.get('tin');
        document.querySelector('.o_email').innerText = formData.get('email');
        document.querySelector('.o_phone').innerText = formData.get('phone');
        document.querySelector('.o_tele').innerText = formData.get('tele');
        document.querySelector('.o_country').innerText = formData.get('country');
        document.querySelector('.o_province').innerText = formData.get('province');
        document.querySelector('.o_city').innerText = formData.get('city');
        document.querySelector('.o_barangay').innerText = formData.get('barangay');
        document.querySelector('.o_subdivision').innerText = formData.get('subdivision');
        document.querySelector('.o_blk').innerText = formData.get('blk');
        document.querySelector('.o_unit').innerText = formData.get('unit');
        document.querySelector('.o_street').innerText = formData.get('street');
        document.querySelector('.o_zip').innerText = formData.get('zip');
        document.querySelector('.o_country1').innerText = formData.get('country2');
        document.querySelector('.o_province1').innerText = formData.get('province2');
        document.querySelector('.o_city1').innerText = formData.get('city2');
        document.querySelector('.o_barangay1').innerText = formData.get('barangay2');
        document.querySelector('.o_subdivision1').innerText = formData.get('subdivision2');
        document.querySelector('.o_blk1').innerText = formData.get('blk2');
        document.querySelector('.o_unit1').innerText = formData.get('unit2');
        document.querySelector('.o_street1').innerText = formData.get('street2');
        document.querySelector('.o_zip1').innerText = formData.get('zip2');
        document.querySelector('.o_fname').innerText = `${formData.get('flast')}, ${formData.get('ffirst')}, ${formData.get('fmiddle')}`;
        document.querySelector('.o_mname').innerText = `${formData.get('mlast')}, ${formData.get('mfirst')}, ${formData.get('mmiddle')}`;
    }

    nextButton.addEventListener('click', (event) => {
        if (validatePage() || currentPage === 4) {
            window.location.href = `index.php?page=${currentPage + 1}`;
        } else {
            event.preventDefault();
        }
    });

    // Civil Status Handling
    function updateStatusDisplay() {
        if (civilStatusSelect.value === 'Others') {
            civilStatusSelect.style.display = 'none';
            otherStatusInput.style.display = 'inline-block';
            otherStatusInput.focus();
        } else {
            otherStatusInput.style.display = 'none';
            civilStatusSelect.style.display = 'inline-block';
        }
    }

    // navigation between pages
    if (sessionStorage.getItem('civil_status') === 'Others') {
        civilStatusSelect.value = 'Others';
        otherStatusInput.value = sessionStorage.getItem('other_status') || '';
        updateStatusDisplay();
    }

    civilStatusSelect.addEventListener('change', () => {
        updateStatusDisplay();
        sessionStorage.setItem('civil_status', civilStatusSelect.value);
    });

    otherStatusInput.addEventListener('input', () => {
        sessionStorage.setItem('other_status', otherStatusInput.value);
    });

    const backArrow = document.createElement('i');
    backArrow.className = 'bx bx-arrow-back back-arrow';
    document.querySelector('.main')?.appendChild(backArrow);
    
    if (currentPage === 1) backArrow.style.display = 'none';

    backArrow.addEventListener('click', () => {
        if (currentPage > 1) {
            window.location.href = `index.php?page=${currentPage - 1}`;
        }
    });

    // Function to toggle sliding effect for Place of Birth & Home Address sections
    function toggleContainer(containerGroupClass, btn) {
        const containerGroup = document.querySelector(`.${containerGroupClass}`);
        const buttons = btn.parentElement.querySelectorAll('.toggle-btn');

        if (!containerGroup) return;

        if (containerGroup.style.transform === "translateX(0%)" || containerGroup.style.transform === "") {
            containerGroup.style.transform = "translateX(-50%)"; // Slide left
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active'); // Highlight active button
        } else {
            containerGroup.style.transform = "translateX(0%)"; // Slide back
            buttons.forEach(b => b.classList.remove('active'));
            buttons[0].classList.add('active'); // Set first button active
        }
    }

    // Attach event listeners to the small circles
    document.querySelectorAll('.toggle-buttons').forEach((toggleGroup, index) => {
        const buttons = toggleGroup.querySelectorAll('.toggle-btn');
        const containerGroupClass = index === 0 ? "container-group-1" : "container-group-2";

        buttons.forEach((btn, btnIndex) => {
            btn.addEventListener('click', function () {
                toggleContainer(containerGroupClass, this);
            });
        });

        // Set first button as active and default transform
        if (buttons.length > 0) {
            buttons[0].classList.add('active');
        }
    });
});
