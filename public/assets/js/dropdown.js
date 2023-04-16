const dropdown = {
    dropdownCategory: document.getElementById('dropdown_category'),
    dropdownProfile: document.getElementById('dropdown_profile'),
    dropdownMenuCategory: document.getElementById('dropdown_menu_category'),
    dropdownMenuProfile: document.getElementById('dropdown_menu_profile'),
    body: document.getElementById('body'),

    init: function() {
        const self = this;

        function toggleActive(element) {
            if (element.classList.contains('active')) {
                element.classList.remove('active');
            } else {
                element.classList.add('active');
            }
        }

        this.dropdownCategory.addEventListener('click', function() {
            toggleActive(self.dropdownMenuCategory);
        });

        this.dropdownProfile.addEventListener('click', function() {
            toggleActive(self.dropdownMenuProfile);
        });

        document.addEventListener('click', function(event) {
            const clickedElement = event.target;

            if (!self.dropdownCategory.contains(clickedElement) && self.dropdownMenuCategory.classList.contains('active')) {
                self.dropdownMenuCategory.classList.remove('active');
            }

            if (!self.dropdownProfile.contains(clickedElement) && self.dropdownMenuProfile.classList.contains('active')) {
                self.dropdownMenuProfile.classList.remove('active');
            }
        });
    }
}

dropdown.init();