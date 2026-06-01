document.addEventListener("DOMContentLoaded",()=>{

    /* ========================================= */
    /* ELEMENTOS */
    /* ========================================= */

    const openLogin =
    document.getElementById("openLogin");

    const loginModal =
    document.getElementById("loginModal");

    const loginTab =
    document.getElementById("loginTab");

    const signupTab =
    document.getElementById("signupTab");

    const loginForm =
    document.getElementById("loginForm");

    const signupForm =
    document.getElementById("signupForm");

    /* ========================================= */
    /* ABRIR MODAL */
    /* ========================================= */

    openLogin.addEventListener("click",()=>{

        loginModal.style.display = "flex";

    });

    /* ========================================= */
    /* CERRAR MODAL */
    /* ========================================= */

    window.addEventListener("click",(e)=>{

        if(e.target === loginModal){

            loginModal.style.display = "none";

        }

    });

    /* ========================================= */
    /* TAB LOGIN */
    /* ========================================= */

    loginTab.addEventListener("click",()=>{

        loginTab.classList.add("active");

        signupTab.classList.remove("active");

        loginForm.classList.remove("hidden");

        signupForm.classList.add("hidden");

    });

    /* ========================================= */
    /* TAB SIGNUP */
    /* ========================================= */

    signupTab.addEventListener("click",()=>{

        signupTab.classList.add("active");

        loginTab.classList.remove("active");

        signupForm.classList.remove("hidden");

        loginForm.classList.add("hidden");

    });

});