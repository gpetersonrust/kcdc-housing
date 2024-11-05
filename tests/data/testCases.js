const testCases = [
  // Landing page 1 (81% AMI and above)
  {
    incomeBracket: 'ib1',
    householdMembers: '7',
    elderly: null,
    disability: null,
    pbv: null,
    expectedUrl: '/81-ami-and-above/',
    bestMatch: ["First Creek"],
  },
  // Landing page 2 (Disabled, Elderly, 61-80% AMI, PBV)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'yes',
    pbv: 'yes',
    expectedUrl: '/disabled-elderly-61-80-ami-pbv/',
    bestMatch: ["Cagle", "Love"],
    secondMatch: ["Clifton", "Eastport", "Northgate", "The Verandas", "Five Points Senior Duplexes"],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 3 (Disabled, Elderly, 61-80% AMI, No PBV)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'yes',
    pbv: 'no',
    expectedUrl: '/disabled-elderly-61-80-ami-no-pbv/',
    bestMatch: ["Cagle", "Love"],
    secondMatch: ["Eastport", "Northgate", "The Verandas", "Five Points Senior Duplexes"],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 4 (Elderly, non-disabled, 61-80% AMI, PBV)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'no',
    pbv: 'yes',
    expectedUrl: '/elderly-non-disabled-61-80-ami-pbv/',
    bestMatch: ["Cagle", "Clifton", "Eastport", "Love", "Northgate", "The Verandas", "Five Points Senior Duplexes"],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 5 (Elderly, non-disabled, 61-80% AMI, No PBV)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'no',
    pbv: 'no',
    expectedUrl: '/elderly-non-disabled-61-80-ami-no-pbv/',
    bestMatch: ["Cagle", "Eastport", "Love", "Northgate", "The Verandas", "Five Points Senior Duplexes"],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 6 (Disabled, non-elderly, 61-80% AMI)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'no',
    disability: 'yes',
    pbv: null,
    expectedUrl: '/disabled-non-elderly-61-80-ami/',
    bestMatch: ["Cagle", "Love"],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 7 (Non-disabled, non-elderly, 61-80% AMI)
  {
    incomeBracket: 'ib2',
    householdMembers: '7',
    elderly: 'no',
    disability: 'no',
    pbv: null,
    expectedUrl: '/non-disabled-non-elderly-61-80-ami/',
    bestMatch: [
      "Autumn Landing", "First Creek", "Five Points Multiplexes", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "Passport Housing", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 8 (Disabled, Elderly, 60% AMI or below, PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'yes',
    pbv: 'yes',
    expectedUrl: '/disabled-elderly-60-ami-or-below-pbv/',
    bestMatch: ["Cagle", "Five Points Residences", "Love"],
    secondMatch: [
      "Clifton", "Eastport", "Northgate", "The Verandas"
    ],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 9 (Disabled, Elderly, 60% AMI or below, No PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'yes',
    pbv: 'no',
    expectedUrl: '/disabled-elderly-60-ami-or-below-no-pbv/',
    bestMatch: ["Cagle", "Five Points Residences", "Love"],
    secondMatch: [
      "Eastport", "Northgate", "The Verandas"
    ],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 10 (Non-disabled, Elderly, 60% AMI or below, PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'no',
    pbv: 'yes',
    expectedUrl: '/non-disabled-elderly-60-ami-or-below-pbv/',
    bestMatch: [
      "Cagle", "Love", "Clifton", "Eastport", 
      "Five Points Residences", "Five Points Senior Duplexes", "Northgate", "The Verandas"
    ],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 11 (Non-disabled, Elderly, 60% AMI or below, No PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'yes',
    disability: 'no',
    pbv: 'no',
    expectedUrl: '/non-disabled-elderly-60-ami-or-below-no-pbv/',
    bestMatch: [
      "Cagle", "Love",   "Eastport", 
      "Five Points Residences", "Five Points Senior Duplexes", "Northgate", "The Verandas"
    ],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 12 (Disabled, non-elderly, 60% AMI or below, PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'no',
    disability: 'yes',
    pbv: 'yes',
    expectedUrl: '/disabled-non-elderly-60-ami-or-below/',
    bestMatch: ["Cagle", "Five Points Residences", "Love"],
    
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  },
  // Landing page 13 (Disabled, non-elderly, 60% AMI or below, No PBV)
  {
    incomeBracket: 'ib3',
    householdMembers: '7',
    elderly: 'no',
    disability: 'yes',
    pbv: 'no',
    expectedUrl: '/non-disabled-non-elderly-60-ami-or-below/',
    bestMatch: ["Cagle", "Five Points Residences", "Love"],
    secondMatch: [
      "Eastport 1", "Eastport 2", "Northgate", "The Verandas"
    ],
    lastMatch: [
      "Autumn Landing", "First Creek", "Five Points 2", "Five Points 3", 
      "Five Points 4", "Five Points Multiplexes", "Lonsdale", "Mechanicsville", 
      "Montgomery Village", "Nature’s Cove", "North Ridge Crossing", "Passport Housing", 
      "The Vista", "Valley Oaks", "Western Heights"
    ],
  }
  
];

exports.testCases = testCases;
