import GP_Moxcar_MetaFieldSelection from '../../../includes/meta-field-section';
import '../scss/app.scss'; // Importing SCSS file
import { PreferenceFilters } from '../../../includes/PreferenceFilters';


document.addEventListener('DOMContentLoaded', () => {
    let row_ids = Object.keys(options).filter(key => key.trim()).map((key) => key + '-row');
    const preferenceFilters = new PreferenceFilters();
    for (const id of row_ids) {
        const metaFieldSelection = new GP_Moxcar_MetaFieldSelection(id);
        metaFieldSelection.init();
        
    }


}   );
