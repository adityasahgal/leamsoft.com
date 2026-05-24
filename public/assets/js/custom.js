document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.header-area');
    const locationInput = document.getElementById('location');
    const locationOptions = document.getElementById('location-options');
    const typeInput = document.getElementById('type');
    const typeOptions = document.getElementById('type-options');
    const budgetInput = document.getElementById('budget');
    const budgetOptions = document.getElementById('budget-options');

    // Change navbar style on scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 0) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Dropdown toggle logic
    function toggleOptions(input, options) {
        if (input && options) {
            input.addEventListener('click', () => {
                options.style.display = options.style.display === 'block' ? 'none' : 'block';
            });
        }
    }

    // Select option from dropdown
    function selectOption(options, input) {
        if (options && input) {
            options.addEventListener('click', (event) => {
                if (event.target.tagName === 'LI') {
                    input.value = event.target.dataset.value;
                    options.style.display = 'none';
                }
            });
        }
    }

    toggleOptions(locationInput, locationOptions);
    selectOption(locationOptions, locationInput);

    toggleOptions(typeInput, typeOptions);
    selectOption(typeOptions, typeInput);

    toggleOptions(budgetInput, budgetOptions);
    selectOption(budgetOptions, budgetInput);

    // Close dropdowns when clicked outside
    document.addEventListener('click', (event) => {
        if (locationInput && !locationInput.contains(event.target) && locationOptions) {
            locationOptions.style.display = 'none';
        }
        if (typeInput && !typeInput.contains(event.target) && typeOptions) {
            typeOptions.style.display = 'none';
        }
        if (budgetInput && !budgetInput.contains(event.target) && budgetOptions) {
            budgetOptions.style.display = 'none';
        }
    });
});
