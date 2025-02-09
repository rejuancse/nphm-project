// Select all accordion buttons
if (document.querySelectorAll('.filter-item').length > 0) {
    var accordionBtns = document.querySelectorAll(".filter-item");

    // Variable to keep track of active accordion
    let activeAccordion = null;

    accordionBtns.forEach((accordion) => {
        accordion.onclick = function (event) {
            event.stopPropagation(); // Prevent the click from propagating to the document

            // Toggle active class
            this.classList.toggle("active");

            // Get content element
            let content = this.nextElementSibling;

            if (activeAccordion && activeAccordion !== this) {
                // Close previously active accordion
                activeAccordion.classList.remove("active");
                activeAccordion.nextElementSibling.style.maxHeight = null;
            }

            if (this.classList.contains("active")) {
                // Set as the active accordion
                activeAccordion = this;
            } else {
                // No active accordion
                activeAccordion = null;
            }

            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        };
    });

    // Event listener to close the accordion when clicking outside
    document.addEventListener('click', function (event) {
        if (activeAccordion && !activeAccordion.contains(event.target)) {
            activeAccordion.classList.remove("active");
            activeAccordion.nextElementSibling.style.maxHeight = null;
            activeAccordion = null;
        }
    });
}

// Filter data fetching
document.addEventListener("DOMContentLoaded", function () {
    if ( document.querySelectorAll( '.tag-checkbox' ).length>0 ) {
        const tagCheckboxes = document.querySelectorAll('.tag-checkbox');
        const items = document.querySelectorAll('.item');
        const loader = document.getElementById('loader');
        const noDataMessage = document.getElementById('no-data-message'); // Add an element for the no data message

        function filterItems() {
            if (loader) {
                loader.style.display = 'block'; // Show loader
            }

            // Simulate data loading with a 600ms delay
            setTimeout(() => {
                const selectedTags = Array.from(tagCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.id);

                let anyVisible = false;

                items.forEach(item => {
                    const itemTags = item.getAttribute('data-tags').split(' ');
                    const tagsMatch = selectedTags.every(tag => itemTags.includes(tag));

                    if (tagsMatch) {
                        item.style.display = 'block';
                        anyVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (loader) {
                    loader.style.display = 'none'; // Hide loader
                }

                if (noDataMessage) {
                    if (!anyVisible) {
                        noDataMessage.style.display = 'block';
                    } else {
                        noDataMessage.style.display = 'none';
                    }
                }
            }, 600);
        }

        tagCheckboxes.forEach(cb => cb.addEventListener('change', filterItems));

        // Initial filter call
        filterItems();
    }
});
