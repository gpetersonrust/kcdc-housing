const { test, expect, describe } = require('@playwright/test');
const { testCases } = require('../data/testCases');
const fs = require('fs');
const { log } = require('console');

describe('Qualified Housing Form Tests', () => {
  testCases.forEach(({ incomeBracket, householdMembers, elderly, disability, pbv, expectedUrl, bestMatch, secondMatch, lastMatch }, index) => {
    test(`Test case ${index + 1}: household members: ${householdMembers}, elderly: ${elderly || 'yes'}, disability: ${disability || 'yes'}, pbv: ${pbv || 'yes'}`, async ({ page }) => {
      await page.goto('http://kcdc-housing.local/qualified-housing-form/');
      await page.locator('#household_members').selectOption(householdMembers);
      
      // Handle elderly status
      const elderlyOption = elderly === 'yes' ? 'yes' : 'no';
      await page.locator(`#elderly_status_${elderlyOption}`).check();

      // Handle disability status
      const disabilityOption = disability === 'yes' ? 'yes' : 'no';
      await page.locator(`#disability_${disabilityOption}`).check();

      // Handle PBV status
      const pbvOption = pbv === 'yes' ? 'yes' : 'no';
      await page.locator(`#pbv_${pbvOption}`).check();

      // Select the income bracket radio button after PBV
      await page.locator(`input[name="income_bracket"][value="${incomeBracket}"]`).check();

      // Submit the eligibility form
      await page.locator('#submit_eligibility_form').click();

      // Check if URL matches the expected URL
      await expect(page).toHaveURL(`http://kcdc-housing.local/qualified-housing${expectedUrl}`);

      const ids = ['bestMatch', 'secondMatch', 'lastMatch'];
 
      for (const id of ids) {
        let housingElements = await page.evaluate((id) => {
          const housingElementContainer = document.getElementById(id);
          if (!housingElementContainer) {
            return [];
          }

          const housingElements = housingElementContainer.querySelectorAll('.housing');
          // Get value from data-alias
          return Array.from(housingElements).map(element => element.getAttribute('data-alias'));
        }, id);

        console.log(housingElements, 'big homie');
        
        // If zero elements are found, continue
        if (housingElements.length === 0) {
          continue;
        }

        const expectedHousingElements = id === 'bestMatch' ? bestMatch : id === 'secondMatch' ? secondMatch : lastMatch;

        // check if expected housing elements is an array 
        if (!Array.isArray(expectedHousingElements)) {
          continue;
        }

        for (const housingElement of expectedHousingElements) {
          let regex = new RegExp(housingElement.trim(), 'i');
          // filter out the housingElement from the housingElements
          let filteredHousingElements = housingElements.filter(element => regex.test(element));
          let doexExist = filteredHousingElements.length > 0;

          await expect(doexExist, `
            Expected ${id} to contain ${housingElement} housing Element is :  ${housingElement} inside of ${housingElements}
            `).toBeTruthy();
            
            
          
          
          // await expect(housingElements, `
          //   Expected ${id} to contain ${housingElement} 
          //   `).toContain(housingElement);
        }
      }
    });
  });
});