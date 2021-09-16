class Global2 {
    constructor() {

    }

    login() {
        $(document).ready(function () {
            $('.acces_admin_page').removeClass('acces_admin_page');
            $('.acces_admin_page').toggleClass('display_block');
            
            $('.homeco').removeClass('homeco');
            $('.homeco').toggleClass('display_block');

           $('.display_block').removeClass('display_block');
            $('.display_block').toggleClass('display_none');

            $('.button_deconnexion').removeClass('button_deconnexion');
            $('.button_deconnexion').toggleClass('display_block');
            $('.button_change_pwd').removeClass('change_psw');
            $('.button_change_pwd').toggleClass('display_block');
        });
    }
}


