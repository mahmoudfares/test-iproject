jQuery.extend(jQuery.validator.messages, 
{
    required: "Dit veld moet worden ingevuld",
    remote: "Please fix this field.",
    email: "Voer een geldig email in",
    url: "Please enter a valid URL.",
    date: "Dit is geen geldige datum",
    dateISO: "Please enter a valid date (ISO).",
    number: "Voer A.U.B alleen hele getallen in.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Voer een getal in tussen de {0} en de {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});