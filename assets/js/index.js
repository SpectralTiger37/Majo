document.addEventListener("DOMContentLoaded", () => {

    const modal =
        document.getElementById("loginModal");

    const openLogin =
        document.getElementById("openLogin");

    const heroLogin =
        document.getElementById("heroLogin");


    const loginTab =
        document.getElementById("loginTab");

    const signupTab =
        document.getElementById("signupTab");


    const loginForm =
        document.getElementById("loginForm");

    const signupForm =
        document.getElementById("signupForm");



    function abrirLogin() {

        modal.style.display = "flex";

        loginForm.classList.remove("hidden");

        signupForm.classList.add("hidden");

        loginTab.classList.add("active");

        signupTab.classList.remove("active");

    }


    openLogin.addEventListener("click", abrirLogin);

    heroLogin.addEventListener("click", abrirLogin);



    loginTab.addEventListener("click", () => {

        loginForm.classList.remove("hidden");

        signupForm.classList.add("hidden");

        loginTab.classList.add("active");

        signupTab.classList.remove("active");

    });



    signupTab.addEventListener("click", () => {

        signupForm.classList.remove("hidden");

        loginForm.classList.add("hidden");

        signupTab.classList.add("active");

        loginTab.classList.remove("active");

    });



    window.addEventListener("click", (e) => {

        if (e.target === modal) {

            modal.style.display = "none";

        }

    });



    if (window.errorLogin) {

        abrirLogin();

    }

});