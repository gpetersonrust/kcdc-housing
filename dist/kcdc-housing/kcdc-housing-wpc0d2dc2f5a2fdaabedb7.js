(()=>{"use strict";const e=class{constructor(e){this.id=e,this.input_name=this.id}init(){this.cacheDom(),this.initializeVars(),this.events()}cacheDom(){this.selectionElement=document.getElementById(this.id),this.selectionUL=this.selectionElement.querySelector(".selection ul"),this.chosenUL=this.selectionElement.querySelector(".chosen ul")}initializeVars(){}events(){this.selectionUL.onclick=e=>{let t=e.target;if(t=t.closest(".choice-item"),t.classList.contains("disabled")||null===t)return;const{id:s,name:i}=t.dataset;this.selectionHandler(t,{id:s,type:"selection",name:i})},this.chosenUL.onclick=e=>{const t=e.target;if(console.log(t,"target"),!t.classList.contains("cancel-button"))return;const s=t.closest(".chosen-item").dataset.id;this.selectionHandler(t,{id:s,type:"chosen"})}}selectionHandler(e,{id:t,type:s,name:i}){if("selection"===s){const s=this.createChosenItem(t,i);s&&(this.chosenUL.appendChild(s),e.classList.add("disabled"))}if("chosen"===s){e.closest(".chosen-item").remove();this.selectionUL.querySelector(`[data-id="${t}"]`).classList.remove("disabled")}}createChosenItem(e,t){if(this.chosenUL.querySelector(`[data-id="${e}"]`))return alert("Item already exists"),null;let s=document.createElement("li");return s.classList.add("chosen-item"),s.dataset.id=e,s.dataset.name=t,s.innerHTML=`\n            <input type="hidden" name="${this.input_name}[]" value="${e}">\n            <span>${t}</span>\n            <div class="cancel-button">-</div>\n        `,s}};class t{constructor(){this.preferenceFilter=document.querySelector("#preferences-filter"),this.defaultRow=document.querySelector(".selection-row.active"),this.selectionRow=document.querySelector(".selection-row"),this.currentRow=this.defaultRow,this.currentTarget=null,this.meta_selection_title=document.querySelector("#meta-selection-title"),this.searchMetaSelectionFilter=new s,this.events(),this.init()}init(){this.preferenceFilter.selectedIndex=1,this.searchMetaSelectionFilter.search(this.defaultRow)}events(){this.preferenceFilter.onchange=e=>{let t=e.target.value.trim();if(t===this.currentTarget)return;const s=e=>e.split(/_|-/).map((e=>e.charAt(0).toUpperCase()+e.slice(1))).join(" ");if("all"===t||""===t){if(this.currentRow===this.defaultRow)return;this.currentRow.classList.remove("active"),this.defaultRow.classList.add("active"),this.currentRow=this.defaultRow,this.currentTarget=t,this.meta_selection_title.textContent=this.default_title}else this.currentRow.classList.remove("active"),this.currentRow=document.querySelector(`.selection-row[data-filter="${t}"]`),this.defaultRow.classList.remove("active"),this.currentRow.classList.add("active"),this.currentTarget=t,console.log(s(t),"value"),this.meta_selection_title.textContent=s(t);this.searchMetaSelectionFilter.resetSearch(this.currentRow)}}}class s{constructor(){this.selectionElement=null,this.searchItem=document.querySelector("#posts-search"),this.searchHandler=this.debounce(this.searchHandler.bind(this),300)}search(e){this.selectionElement=e,this.searchItem&&this.searchItem.addEventListener("keyup",this.searchHandler)}searchHandler(e){const t=e.target.value;console.log(t,"value");let s=this.selectionElement.querySelectorAll(".choice-item"),i=this.selectionElement.querySelectorAll(".chosen-item");s=[...s,...i],s.forEach((e=>{e.dataset.name.toLowerCase().indexOf(t.toLowerCase())>-1?e.style.display="flex":e.style.display="none"}))}resetSearch(e){this.searchItem.value="";let t=this.selectionElement.querySelectorAll(".choice-item"),s=this.selectionElement.querySelectorAll(".chosen-item");t=[...t,...s],t.forEach((e=>{e.style.display="flex"})),this.searchItem&&this.searchItem.removeEventListener("keyup",this.searchHandler),this.search(e)}debounce(e,t){let s;return function(...i){clearTimeout(s),s=setTimeout((()=>e.apply(this,i)),t)}}}document.addEventListener("DOMContentLoaded",(()=>{let s=Object.keys(options).filter((e=>e.trim())).map((e=>e+"-row"));new t;for(const t of s){new e(t).init()}}))})();
//# sourceMappingURL=kcdc-housing-wpc0d2dc2f5a2fdaabedb7.js.map