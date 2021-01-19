/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue2-datepicker-miercuri', require('./components/DatePickerMiercuri.vue').default);
Vue.component('vue2-datepicker-duminica', require('./components/DatePickerDuminica.vue').default);
Vue.component('vue2-datepicker-buletin', require('./components/DatePickerBuletin.vue').default);
Vue.component('vue2-datepicker', require('./components/DatePicker.vue').default);
Vue.component('vue2-datepicker-time', require('./components/DatePickerTime.vue').default);
Vue.component('vuejs-datepicker', require('./components/Vuejs-datepicker.vue').default);

Vue.component('vue2-editor', require('./components/Vue2Editor.vue').default);
Vue.component('tiptap-editor', require('./components/TipTapEditor.vue').default);
Vue.component('tinymce-editor', require('./components/Tinymce.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.querySelector('#app1')) {
    const app1 = new Vue({
        el: '#app1'
    });
}



if (document.querySelector('#produse')) {
    const app = new Vue({
        el: '#produse',
        methods: {
            formfocus() {
                document.getElementById("search_cod_de_bare").focus();
            }
        },
        mounted() {
            this.formfocus()
        }
    });
}

if (document.querySelector('#fisa-service')) {
    const app = new Vue({
        el: '#fisa-service',
        data: {
            client_deja_inregistrat: clientVechi,
            clienti: clientiExistenti,
            client_nume: clientVechi_nume,
            // client_nume_scurt: clientVechi_nume_scurt,
            client_nr_ord_reg_com: clientVechi_nr_ord_reg_com,
            client_cui: clientVechi_cui,
            client_adresa: clientVechi_adresa,
            client_iban: clientVechi_iban,
            client_banca: clientVechi_banca,
            client_reprezentant: clientVechi_reprezentant,
            client_reprezentant_functie: clientVechi_reprezentant_functie,
            client_telefon: clientVechi_telefon,
            client_email: clientVechi_email,
            // client_email_dpo: clientVechi_email_dpo,
            client_site_web: clientVechi_site_web,
        },
        created: function () {
            this.getDateClient()
        },
        methods: {
            getDateClient: function () {
                for (var i = 0; i < this.clienti.length; i++) {
                    if (this.clienti[i].id == this.client_deja_inregistrat) {
                        this.client_nume = this.clienti[i].nume;
                        // this.client_nume_scurt = this.clienti[i].nume_scurt;
                        this.client_nr_ord_reg_com = this.clienti[i].nr_ord_reg_com;
                        this.client_cui = this.clienti[i].cui;
                        this.client_adresa = this.clienti[i].adresa;
                        this.client_iban = this.clienti[i].iban;
                        this.client_banca = this.clienti[i].banca;
                        this.client_reprezentant = this.clienti[i].reprezentant;
                        this.client_reprezentant_functie = this.clienti[i].reprezentant_functie;
                        this.client_telefon = this.clienti[i].telefon;
                        this.client_email = this.clienti[i].email;
                        // this.client_email_dpo = this.clienti[i].email_dpo;
                        this.client_site_web = this.clienti[i].site_web;
                        return true;
                    }
                }
                // this.client_nume = '';
                // this.client_nr_ord_reg_com = '';
                // this.client_cui = '';
                // this.client_adresa = '';
                // this.client_iban = '';
                // this.client_banca = '';
                // this.client_reprezentant = '';
                // this.client_reprezentant_functie = '';
                // this.client_telefon = '';
                // this.client_email = '';
                // this.client_site_web = '';

            },
            changeDateClient: function () {
                for (var i = 0; i < this.clienti.length; i++) {
                    if (this.clienti[i].id == this.client_deja_inregistrat) {
                        this.client_nume = this.clienti[i].nume;
                        // this.client_nume_scurt = this.clienti[i].nume_scurt;
                        this.client_nr_ord_reg_com = this.clienti[i].nr_ord_reg_com;
                        this.client_cui = this.clienti[i].cui;
                        this.client_adresa = this.clienti[i].adresa;
                        this.client_iban = this.clienti[i].iban;
                        this.client_banca = this.clienti[i].banca;
                        this.client_reprezentant = this.clienti[i].reprezentant;
                        this.client_reprezentant_functie = this.clienti[i].reprezentant_functie;
                        this.client_telefon = this.clienti[i].telefon;
                        this.client_email = this.clienti[i].email;
                        // this.client_email_dpo = this.clienti[i].email_dpo;
                        this.client_site_web = this.clienti[i].site_web;
                        return true;
                    }
                }
                this.client_nume = '';
                this.client_nr_ord_reg_com = '';
                this.client_cui = '';
                this.client_adresa = '';
                this.client_iban = '';
                this.client_banca = '';
                this.client_reprezentant = '';
                this.client_reprezentant_functie = '';
                this.client_telefon = '';
                this.client_email = '';
                this.client_site_web = '';

            },
            // formfocus() {
            //     document.getElementById("cod_de_bare").focus();
            // }
        },
        mounted() {
            // this.formfocus()
        }
    });
}

if (document.querySelector('#sms-personalizat')) {
    const app = new Vue({
        el: '#sms-personalizat',
        data: {
            sms_personalizat: '',
            nr_caractere: 0
        },
        computed: {
            caractere() {
                var char = this.sms_personalizat.length;
                return char;
            }
        }
    });
}