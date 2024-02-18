// multilanguage.js

// Define loadGoogleTranslate function
function loadGoogleTranslate(selectedLanguage) {
    new google.translate.TranslateElement({
        pageLanguage: 'en',  // Change this to your default language
        includedLanguages: [selectedLanguage],
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}

// Script to handle language change
function changeLanguage() {
    // Get the selected language from the myid element
    var selectedLanguage = document.getElementById('myid').value;
    // Save selected language preference in local storage
    localStorage.setItem('selectedLanguage', selectedLanguage);
    // Reload the page to apply the new language
    location.reload();
}

// Retrieve selected language preference from local storage
var selectedLanguage = localStorage.getItem('selectedLanguage');
if (selectedLanguage) {
    loadGoogleTranslate(selectedLanguage);
    // Set the selected language in the dropdown
    document.getElementById('language_select').value = selectedLanguage;
}

