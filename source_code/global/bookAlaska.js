class Global {
    constructor() {
    }

    general() {
        document.querySelectorAll('.display_block').forEach(e => e.addEventListener('click', event => {
            document.getElementsByClassName('login_area')[0].style.display = "block";
        }));
        document.querySelectorAll('.leave_login_area').forEach(e => e.addEventListener('click', event => {
            document.getElementsByClassName('login_area')[0].style.display = "none";
        }));
        
        document.querySelectorAll('.down_arrow').forEach(e => e.addEventListener('click', event => {
            // 
            $('html,body').animate({
                scrollTop: $("#concept").offset().top
            }, 'slow');
        }));
        document.querySelectorAll('.button_mdp_oublie').forEach(e => e.addEventListener('click', event => {
            document.getElementsByClassName('form_forgot_pwd')[0].style.display = "block";
        }));
        
        document.querySelectorAll('.menu_burger').forEach(e => e.addEventListener('click', event => {
            document.getElementsByTagName('header')[0].style.display = "flex";
            document.getElementsByTagName('header')[0].style.height = "100vh";

            document.getElementsByTagName('header')[0].style.flexDirection = "column";
            document.getElementsByClassName('menu_classique')[0].style.display = "flex";
            document.getElementsByClassName('menu_classique')[0].style.flexDirection = "column";
            document.getElementsByClassName('menu_classique')[0].style.textAlign = "center";
            document.getElementsByClassName('menu_classique')[0].style.height = "90%";
            document.getElementsByClassName('close_menu_burger')[0].style.display = "block";

            document.getElementsByClassName('menu_burger')[0].style.display = "none";

        }));
        document.querySelectorAll('.close_menu_burger').forEach(e => e.addEventListener('click', event => {
            
            document.getElementsByClassName('menu_burger')[0].style.display = "block";
            document.getElementsByClassName('close_menu_burger')[0].style.display = "none";
            document.getElementsByClassName('menu_classique')[0].style.display = "none";

            document.getElementsByTagName('header')[0].style.height = "auto";
            
            document.getElementsByTagName('header')[0].style.minHeight = "10%";

            document.getElementsByTagName('header')[0].style.justifyContent = "flex-end";
            document.getElementsByTagName('header')[0].style.flexDirection = "row";

        }))
    }

}


let global = new Global();
global.general();


