;
let passwordField = document.getElementById("passId");
let passwordFieldConfirm = document.getElementById("passSecId");
let passwordProgressBarWrapper = document.getElementById("progress-bar-wrap-id");
let passwordProgressBar = document.getElementById("progress-bar-id");
let passwordHintTextList = document.getElementById("passwordHintTextList");
let passwordHintConfirmTextList = document.getElementById("passwordHintConfirmTextList");

const regexCapital = /^[A-Z]{4,20}$/g;
const regexLower = /^[a-z]{4,20}$/g;
const regexNum = /^[0-9]{4,20}$/g;
const regexCapitalLower = /^(?=.*[a-z]{4,20})(?=.*[A-Z]{4,20})([a-zA-Z]+)$/g;
const regexLowerNumber = /^(?=.*[a-z]{4,20})(?=.*[0-9]{4,20})([a-z0-9]+)$/g;
const regexCapitalNumber = /^(?=.*[A-Z]{4,20})(?=.*[0-9]{4,20})([A-Z0-9]+)$/g;
const regexCapitalLowerNumber = /^(?=.*[a-z]{4,20})(?=.*[A-Z]{4,20})(?=.*[0-9]{4,20})([a-zA-Z0-9]+)$/g;
const regexCapitalLowerNumberSpecial = /^(?=.*[a-z]{4,20})(?=.*[A-Z]{4,20})(?=.*[0-9]{4,20})(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{1,10})([a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+)$/g;
const regexSpecialCharacters = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g;
const charactersLengthElement = passwordHintTextList.getElementsByClassName("password-hint-child")[0];
const charactersElement = passwordHintTextList.getElementsByClassName("password-hint-child")[1];
const confirmElement = passwordHintConfirmTextList.getElementsByClassName("password-hint-child")[0];

passwordField.addEventListener("focus", () => {
    passwordHintTextList.hidden = false;
    passwordProgressBarWrapper.hidden = false;
});

passwordField.addEventListener("focusout", () => {
    passwordHintTextList.hidden = true;
    passwordProgressBarWrapper.hidden = true;
});

passwordFieldConfirm.addEventListener("focus", () => {
    passwordHintConfirmTextList.hidden = false;
});

passwordFieldConfirm.addEventListener("focusout", () => {
    passwordHintConfirmTextList.hidden = true;
});

passwordField.addEventListener("keyup", () => {

    let passwordText = passwordField.value;

    if (passwordText.match(regexCapital) || passwordText.match(regexLower) || passwordText.match(regexNum)) {
        passwordProgressBar.style.width = "25%";
        passwordProgressBar.setAttribute("aria-valuenow", "25");
    } else if (passwordText.match(regexCapitalLower) || passwordText.match(regexLowerNumber) || passwordText.match(regexCapitalNumber)) {
        passwordProgressBar.style.width = "50%";
        passwordProgressBar.style.background = "#FFA900";
        passwordProgressBar.setAttribute("aria-valuenow", "50");
    } else if (passwordText.match(regexCapitalLowerNumber)) {
        passwordProgressBar.style.width = "75%";
        passwordProgressBar.style.background = "yellow";
        passwordProgressBar.setAttribute("aria-valuenow", "75");
    } else if (passwordText.match(regexCapitalLowerNumberSpecial)) {
        passwordProgressBar.style.width = "100%";
        passwordProgressBar.style.background = "#00B74A";
        passwordProgressBar.setAttribute("aria-valuenow", "100");
    } else {
        passwordProgressBar.style.width = "1%";
        passwordProgressBar.style.background = "#F93154";
        passwordProgressBar.setAttribute("aria-valuenow", "1");
    }
    if (passwordText.length >= 8 && passwordText.length <= 20) {
        charactersLengthElement.style.color = "#00B74A";
    } else {
        charactersLengthElement.style.color = "#F93154";
    }
    if (passwordText.match(regexSpecialCharacters)) {
        charactersElement.style.color = "#00B74A";
    } else {
        charactersElement.style.color = "#F93154";
    }
});

passwordFieldConfirm.addEventListener("keyup", () => {

    let passwordText = passwordField.value;
    let passwordConfirmText = passwordFieldConfirm.value;

    if (passwordText !== passwordConfirmText) {
        confirmElement.style.color = "#F93154";
    } else {
        confirmElement.style.color = "#00B74A";
    }
});
