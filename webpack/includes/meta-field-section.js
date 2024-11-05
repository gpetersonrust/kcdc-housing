class GP_Moxcar_MetaFieldSelection {
    constructor(id) {
        this.id = id;
        this.input_name = this.id;
       
     }
    init() {
        this.cacheDom();
        this.initializeVars();
        this.events();
   
    }
    cacheDom() { 
        this.selectionElement = document.getElementById(this.id);
        // choice elements without disabled class
        this.selectionUL = this.selectionElement.querySelector('.selection ul');
        this.chosenUL = this.selectionElement.querySelector('.chosen ul');
    
    }
    initializeVars() { }
    events() {
        this.selectionUL.onclick = (e) => {
            let target = e.target; // the element that was clicked
            target = target.closest('.choice-item'); // the closest parent element that has the class choice-item
            let has_disabled = target.classList.contains('disabled'); // check if the element has the class disabled
            let isNull = target === null; // check if the element is null
            if (has_disabled || isNull)  { // if the element has the class disabled or is null, return
                return;
            }
 
           
            
            
             const {id, name} = target.dataset;
            
            const type = 'selection';
            this.selectionHandler(target, { id, type, name });
           

        }

        this.chosenUL.onclick = (e) => {
            const target = e.target;
            console.log(target, 'target');

            if (!target.classList.contains('cancel-button')) {
                return;
            }
            const  id = target.closest('.chosen-item').dataset.id;
            const type = 'chosen';
            this.selectionHandler(target, {id, type});
        }

       
       
     }
   

    selectionHandler(target, {id, type, name}) {
        // if type is selection, add to chosen
        if (type === 'selection') {
             
            const chosenItem = this.createChosenItem(id, name);
            if (chosenItem) {
                this.chosenUL.appendChild(chosenItem);
                // add disable class to item on selection list
                target.classList.add('disabled');
            }
        }

        if (type === 'chosen') {
            const chosenItem = target.closest('.chosen-item');
            chosenItem.remove();
            // remove disable class from item on selection list
            const selectionItem = this.selectionUL.querySelector(`[data-id="${id}"]`);
            selectionItem.classList.remove('disabled');

        }
        // if type is chosen, add to selection
    }

    // main methods


    // helper methods

    createChosenItem(id, name) {
        // check if the item already exists in the chosen list
        // if it does, return null

        if (this.chosenUL.querySelector(`[data-id="${id}"]`)) {
            alert('Item already exists');
            return null;
        }
        let li = document.createElement('li');
        li.classList.add('chosen-item');
        li.dataset.id = id;
        li.dataset.name = name;
        li.innerHTML = `
            <input type="hidden" name="${this.input_name}[]" value="${id}">
            <span>${name}</span>
            <div class="cancel-button">-</div>
        `;
        
        return li;
    }

}

export default GP_Moxcar_MetaFieldSelection;