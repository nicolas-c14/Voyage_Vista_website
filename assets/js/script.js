/* =========================
   INIT
========================= */

document.addEventListener("DOMContentLoaded", function () {

    initializeRegisterValidation();

});

/* =========================
   REGISTER VALIDATION
========================= */

function initializeRegisterValidation() {

    const registerForm =
        document.getElementById("registerForm");

    if (!registerForm) {
        return;
    }

    const passwordInput =
        document.getElementById("password");

    const confirmPasswordInput =
        document.getElementById("confirmPassword");

    /* =========================
       RESET ERRORS LIVE
    ========================= */

    passwordInput.addEventListener("input", resetPasswordErrors);

    confirmPasswordInput.addEventListener("input", resetPasswordErrors);

    /* =========================
       FORM SUBMIT
    ========================= */

    registerForm.addEventListener("submit", function (event) {

        if (!validatePassword()) {

            event.preventDefault();

        }

    });

}

/* =========================
   PASSWORD REGEX
========================= */

function validateMDPCarac(password) {

    const regex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,}$/;

    return regex.test(password);

}

/* =========================
   RESET ERRORS
========================= */

function resetPasswordErrors() {

    document
        .getElementById("password")
        .setCustomValidity("");

    document
        .getElementById("confirmPassword")
        .setCustomValidity("");

}

/* =========================
   VALIDATE PASSWORD
========================= */

function validatePassword() {

    const passwordInput =
        document.getElementById("password");

    const confirmPasswordInput =
        document.getElementById("confirmPassword");

    const password =
        passwordInput.value;

    const confirmPassword =
        confirmPasswordInput.value;

    /* =========================
       PASSWORD RULES
    ========================= */

    if (!validateMDPCarac(password)) {

        passwordInput.setCustomValidity(
            "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
        );

        passwordInput.reportValidity();

        return false;

    }

    /* =========================
       PASSWORD MATCH
    ========================= */

    if (password !== confirmPassword) {

        confirmPasswordInput.setCustomValidity(
            "Les mots de passe ne correspondent pas."
        );

        confirmPasswordInput.reportValidity();

        return false;

    }

    return true;

}