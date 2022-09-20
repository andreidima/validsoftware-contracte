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

            // client_nume_autocomplete: '',
            // clienti_lista_autocomplete: '',

            client_nume_autocomplete2: '',
            clienti_lista_autocomplete2: [],

            servicii: servicii,
            servicii_selectate: serviciiSelectate,
            // servicii_selectate: []

            fise_vechi_client: [],
            nume_camp: '',
            valoare_camp: '',
            fise_lista_autocomplete: [],

            descriere_echipament: descriereEchipament,
        },
        watch: {
            client_deja_inregistrat: function () {
                this.getFiseVechi();
                this.fise_lista_autocomplete = '';
            },
        },
        created: function () {
            this.getDateClient()
        },
        methods: {
            getDateClient: function () {
                for (var i = 0; i < this.clienti.length; i++) {
                    if (this.clienti[i].id == this.client_deja_inregistrat) {
                        // this.client_nume_autocomplete = this.clienti[i].nume;
                        this.client_nume_autocomplete2 = this.clienti[i].nume;

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
                        // this.client_nume_autocomplete = this.clienti[i].nume;
                        this.client_nume_autocomplete2 = this.clienti[i].nume;

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
            // },

            // Autocomplete pentru datele clientului cu Axios
            // autoComplete: function () {
            //     this.clienti_lista_autocomplete = '';
            //     if (this.client_nume_autocomplete.length > 2) {
            //         axios.get('/vuejs/autocomplete/search', {
            //             params: {
            //                 client_nume: this.client_nume_autocomplete
            //             }
            //         })
            //             .then(response => {
            //                 this.clienti_lista_autocomplete = response.data;
            //             });
            //     }
            // },

            // Autocomplete pentru datele clientului folosind clientii trimisi din start in vuejs
            autoComplete2: function () {
                this.clienti_lista_autocomplete2 = [];
                if (this.client_nume_autocomplete2.length > 2) {
                    for (var i = 0; i < this.clienti.length; i++) {
                        if (this.clienti[i].nume.toLowerCase().includes(this.client_nume_autocomplete2.toLowerCase())) {

                            // this.clienti_lista_autocomplete.push(this.clienti[i])
                            this.clienti_lista_autocomplete2.push(this.clienti[i]);
                            // this.clienti_lista_autocomplete2 = 'asd';
                        } else if (this.clienti[i].telefon && this.clienti[i].telefon.toLowerCase().includes(this.client_nume_autocomplete2.toLowerCase())) {
                            this.clienti_lista_autocomplete2.push(this.clienti[i]);
                        }
                    }
                }
            },

            getFiseVechi: function () {
                // console.log('here');
                axios.get('/service/fise/axios/fise-vechi', {
                    params: {
                        request: 'fise_vechi',
                        client_id: this.client_deja_inregistrat,
                    }
                })
                    .then(function (response) {
                        app.fise_vechi_client = response.data.raspuns;
                        // console.log(response.data.raspuns);
                    });
                },
            autocomplete() {
                this.fise_lista_autocomplete = [];
                var nume_camp = this.nume_camp;
                var valoare_camp = this.valoare_camp;
                // if (valoare_camp.length > 0) { // campul de cautare trebuie sa aiba minim 1 caracter
                    for (var i = 0; i < this.fise_vechi_client.length; i++) { // se parcurg toate fisele vechi
                        if (this.fise_vechi_client[i][nume_camp]) { // daca respectiva fisa are o valoare in respectivul camp
                            if ((!valoare_camp) || (valoare_camp && this.fise_vechi_client[i][nume_camp].toLowerCase().includes(valoare_camp.toLowerCase()))) { // daca elementul are stringul de cautare
                                if (!this.fise_lista_autocomplete.includes(this.fise_vechi_client[i][nume_camp])) { // daca elementul nu este deja inclus
                                    this.fise_lista_autocomplete.push(this.fise_vechi_client[i][nume_camp]); // se adauga elementul in array
                                }
                            }
                        }
                    }
                // }
                this.fise_lista_autocomplete.sort();
            },


            select: function (value, event) {
                // this.servicii_selectate = ['a'];
                var servicii_selectate = this.servicii_selectate;

                if (event.target.checked) {
                    this.servicii.forEach(function (serviciu) {
                        if (serviciu.categorie_id == value){
                            if (!servicii_selectate.includes(serviciu.id)) {
                                servicii_selectate.push(serviciu.id);
                                console.log(serviciu.id);
                            }
                                console.log(servicii_selectate);
                        }
                    });
                } else {
                    this.servicii.forEach(function (serviciu) {
                        if (serviciu.categorie_id == value) {
                            for (var i = servicii_selectate.length - 1; i >= 0; i--) {
                                if (servicii_selectate[i] == serviciu.id) {
                                    servicii_selectate.splice(i, 1);
                                }
                            }
                        }
                    });
                }

                this.servicii_selectate = servicii_selectate;
            }

        },
        mounted() {
            // this.formfocus()
        }
    });
}

if (document.querySelector('#ofertare')) {
    const app = new Vue({
        el: '#ofertare',
        data: {
            client_id: clientVechi,
            clienti: clientiExistenti,

            client_nume: '',
            clienti_lista: []
        },
        created: function () {
            this.getNumeClient()
        },
        methods: {
            getNumeClient: function () {
                this.client_nume = '';
                for (var i = 0; i < this.clienti.length; i++) {
                    if (this.clienti[i].id == this.client_id) {
                        this.client_nume = this.clienti[i].nume;
                        return true;
                    }
                }
            },
            // Autocomplete pentru datele clientului folosind clientii trimisi din start in vuejs
            autoComplete: function () {
                this.clienti_lista = [];
                if (this.client_nume.length > 2) {
                    for (var i = 0; i < this.clienti.length; i++) {
                        if (this.clienti[i].nume && this.clienti[i].nume.toLowerCase().includes(this.client_nume.toLowerCase())) {
                            this.clienti_lista.push(this.clienti[i]);
                        } else if (this.clienti[i].telefon && this.clienti[i].telefon.toLowerCase().includes(this.client_nume.toLowerCase())) {
                            this.clienti_lista.push(this.clienti[i]);
                        }
                    }
                }
            },
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

if (document.querySelector('#copy_to_clipboard')) {
    const app = new Vue({
        el: '#copy_to_clipboard',
        data: {
            appId1: ((typeof appIdVechi !== 'undefined') ? appIdVechi : ''),
            appId: '3493993048904',
            appToken: 'dksklq33lkj21kjl12lkdsasd21jk',
            canCopy: false
        },
        created() {
            this.canCopy = !!navigator.clipboard;
        },
        methods: {
            async copy(s) {
                await navigator.clipboard.writeText(s);
                alert('Copied!');
            }
        }
    });
}

if (document.querySelector('#fise')) {
    const app = new Vue({
        el: '#fise',
        data: {
            sms_personalizat: '',
            nr_caractere: 0,

            canCopy: false, // pentru copy paste
            flag: false // pentru tooltip
        },

        // Pentru copy paste
        created() {
            this.canCopy = !!navigator.clipboard;
        },
        methods: {
            async copy(s) {
                await navigator.clipboard.writeText(s);
                // alert('Copied!');

                this.flag = true
                setTimeout(() => {
                    this.flag = false
                }, 3000)
            }
        },

        // Pentru SMS
        computed: {
            caractere() {
                var char = this.sms_personalizat.length;
                return char;
            }
        }
    });


}
