 
<form 
    id="housing-eligibility-form" 
    class="housing-eligibility-form"
    method="post" action="">
    <?php wp_nonce_field('housing_eligibility_nonce_action', 'housing_eligibility_nonce'); // Add nonce field ?>


    <div class="kcdc-housing-field"> 
        <p for="income_bracket"> How many members In Household? </p>
        <select name="household_members" id="household_members" required>
            <option value="" disabled selected>Select Number of Members In Household</option> <!-- Placeholder option -->
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </div>

    <div class="kcdc-housing-field" 
     style="display: none;" id="income_bracket_field"
    >
        <!-- select income bracket dynamically -->
         <p for="income_bracket">What is your annual income?</p>
          <!-- radio buttons  -->
    </div>

 
    <div class="kcdc-housing-field"> 
        <p> Are you 50 years of age or older?</p>
        <div class="kcdc-radio-field">
            <input type="radio" name="elderly_status" value="yes" id="elderly_status_yes" required>
            <label for="elderly_status_yes">Yes</label>
        </div>
        <div class="kcdc-radio-field">
            <input type="radio" name="elderly_status" value="no" id="elderly_status_no" required>
            <label for="elderly_status_no">No</label>
        </div>
    </div>
    
    <div class="kcdc-housing-field"> 
        <p>Do you receive Supplemental Security Income (SSI), Social Security Disability Insurance (SSDI), or have you been medically diagnosed as disabled?</p>
        <div class="kcdc-radio-field"> 
            <input type="radio" name="disability_status" value="yes" id="disability_yes" required>
            <label for="disability_yes">Yes</label>
        </div>
        <div class="kcdc-radio-field">
            <input type="radio" name="disability_status" value="no" id="disability_no" required>
            <label for="disability_no">No</label>
        </div>
    </div>
    
    <div class="kcdc-housing-field"> 
        <p>Do you hold a Project-Based Voucher (PBV)?</p>
        <div class="kcdc-radio-field">
            <input type="radio" name="pbv_status" value="yes" id="pbv_yes" required>
            <label for="pbv_yes">Yes</label>
        </div>
        <div class="kcdc-radio-field">
            <input type="radio" name="pbv_status" value="no" id="pbv_no" required>
            <label for="pbv_no">No</label>
        </div>
    </div>

    <p><input id="submit_eligibility_form" type="submit" name="submit_eligibility_form" value="Submit"></p>
</form>


<script>
    let income_brackets = [
        {
        id: 1,
        options: {
            "ib1": "Above $48,400",
            "ib2": "$48,400 - $36,301",
            "ib3": "$36,300 or below"
        }
    }, 
    {
        id: 2,
        options: {
            "ib1": "$55,300 or above",
            "ib2": "$55,300 - $41,521",
            "ib3": "$41,520 or below"
        }
    }, 
    {
        id: 3,
        options: {
            "ib1": "$62,200 or above",
            "ib2": "$62,200 - $46,681",
        "ib3": "$46,680 or below"
        }
    }, 
    {
        id: 4,
        options: {
            "ib1": "$69,100 or above",
            "ib2": "$69,100 - $51,841",
            "ib3": "$51,840 or below"
        }
    }, 
    {
        id: 5,
        options: {
            "ib1": "$74,650 or above",
            "ib2": "$74,650 - $56,041",
            "ib3": "$56,040 or below"
        }
    },

    {
        id: 6,
        options: {
            "ib1": "$80,200 or above",
            "ib2": "$80,200 - $60,181",
            "ib3": "$60,180 or below"
        }
    }, 
    {
        id: 7,
        options: {
            "ib1": "$85,700 or above",
            "ib2": "$85,700 - $64,321",
            "ib3": "$64,320 or below"
        }
    }


    
    ]; 

    let household_members = document.getElementById('household_members');

    // Add event listener to household members select
    household_members.addEventListener('change', function() {
        let selected_household_members = household_members.value;
        let income_bracket_field = document.getElementById('income_bracket_field');
        let income_bracket_options = income_brackets[selected_household_members - 1].options;
        let income_bracket_field_html = '<p for="income_bracket">What is your annual income?</p>';
        const styles =  `display: flex; gap: 8px; align-items: center; margin-bottom: 4px;`;
        for (let key in income_bracket_options) {
            income_bracket_field_html += `
            <div class="kcdc-radio
            -field"
            style="${styles}"
            >
                <input type="radio" name="income_bracket" value="${key}" id="${key}">
                <label for="${key}">${income_bracket_options[key]}</label>
            </div>

            `;
        }
        income_bracket_field.innerHTML = income_bracket_field_html;
        income_bracket_field.style.display = 'block';
    });


</script>