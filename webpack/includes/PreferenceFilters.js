export class PreferenceFilters {
    constructor() {
        this.preferenceFilter = document.querySelector('#preferences-filter');
        this.defaultRow = document.querySelector('.selection-row.active');
        this.selectionRow = document.querySelector('.selection-row'); // Fixed typo
        this.currentRow = this.defaultRow;
        this.currentTarget = null;
        this.meta_selection_title = document.querySelector('#meta-selection-title');
        this.searchMetaSelectionFilter = new searchMetaSelectionFilter();
        this.events();
        this.init();
    }

    init() {
        // Select first option in the preference filter:
        this.preferenceFilter.selectedIndex = 1;

        // Set search for meta selection filter first element to match the first row 
        this.searchMetaSelectionFilter.search(this.defaultRow);
    }

    events() {
        this.preferenceFilter.onchange = (e) => {
            let target = e.target;
            let value = target.value.trim();

            if (value === this.currentTarget) {
                return;
            }

            const convertValueToUpperCaseByEachWord = (value) => {
                return value
                    .split(/_|-/)
                    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(" ");
            };

            if (value === 'all' || value === "") {
                // Check if the current row is the default row
                if (this.currentRow === this.defaultRow) {
                    return;
                }
                this.currentRow.classList.remove('active');
                this.defaultRow.classList.add('active');
                this.currentRow = this.defaultRow;
                this.currentTarget = value;

                // Set the meta section title to the default value
                this.meta_selection_title.textContent = this.default_title;

            } else {
                this.currentRow.classList.remove('active');

                // Get the current row via filter value
                this.currentRow = document.querySelector(`.selection-row[data-filter="${value}"]`);
                this.defaultRow.classList.remove('active');
                this.currentRow.classList.add('active');
                this.currentTarget = value;

                console.log(convertValueToUpperCaseByEachWord(value), 'value');
                this.meta_selection_title.textContent = convertValueToUpperCaseByEachWord(value);
            }

            // Reset search for meta selection filter
            this.searchMetaSelectionFilter.resetSearch(this.currentRow);
        };
    }
}

class searchMetaSelectionFilter {
    constructor() {
        this.selectionElement = null;
        this.searchItem = document.querySelector('#posts-search');
        this.searchHandler = this.debounce(this.searchHandler.bind(this), 300); // Added debouncing
    }

    search(selectionElement) {
        this.selectionElement = selectionElement;
      
        
        if (this.searchItem) { // Check if the search item exists
            this.searchItem.addEventListener('keyup', this.searchHandler);
        }
    }

    searchHandler(e) {
        const value = e.target.value;
        console.log(value, 'value');
        let items = this.selectionElement.querySelectorAll('.choice-item');
        let chosenItems = this.selectionElement.querySelectorAll('.chosen-item');

        // Combine both items
        items = [...items, ...chosenItems];
        items.forEach(item => {
            const name = item.dataset.name;
            if (name.toLowerCase().indexOf(value.toLowerCase()) > -1) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    resetSearch(selectionElement) {
        this.searchItem.value = '';
        let items = this.selectionElement.querySelectorAll('.choice-item');
        let chosenItems = this.selectionElement.querySelectorAll('.chosen-item');

        // Combine both items
        items = [...items, ...chosenItems];
        items.forEach(item => {
            item.style.display = 'flex';
        });

        // Remove event listener from this.searchItem
        if (this.searchItem) { // Check if the search item exists
            this.searchItem.removeEventListener('keyup', this.searchHandler);
        }

        this.search(selectionElement);
    }

    debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }
}
