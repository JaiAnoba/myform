document.addEventListener("DOMContentLoaded", function () {
    let pages = document.querySelectorAll(".page1, .page2, .page3");
    let button = document.querySelector(".done");
    let currentPage = 0;

    // Hide all pages initially and show only the first page
    pages.forEach((page, index) => {
        page.style.display = index === 0 ? "block" : "none";
    });

    button.addEventListener("click", function (event) {
        // Prevent default form submission
        event.preventDefault();
        page.style.display = index === 0 ? "block" : "none";
    });

    button.addEventListener("click", function (event) {
        // Prevent default form submission
        event.preventDefault();

        // Only proceed if no PHP validation errors are present
        if (document.querySelectorAll(".error").length === 0) {
            if (currentPage < pages.length - 1) {
                pages[currentPage].style.display = "none";
                currentPage++;
                pages[currentPage].style.display = "block";
                if (currentPage === pages.length - 1) {
                    button.textContent = "Submit";
                }
            } else {
                // Submit the form when on the last page
                document.querySelector("form").submit();
            }
        } else {
            alert("Please correct the errors before proceeding.");
        }
    });
});
