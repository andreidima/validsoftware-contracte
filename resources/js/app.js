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

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

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

if (document.querySelector('#adauga-rezervare')) {
    const app1 = new Vue({
        el: '#adauga-rezervare',
        data: {
            traseu: traseuVechi,
            active: "active",
            oras_plecare: orasPlecareVechi,
            orase_plecare: '',
            oras_sosire: orasSosireVechi,
            orase_sosire: '',

            nr_adulti: nrAdultiVechi,
            nr_copii: nrCopiiVechi,
            nr_animale_mici: nrAnimaleMiciVechi,
            nr_animale_mari: nrAnimaleMariVechi,

            pret_adult: 0,
            pret_copil: 0,
            pret_animal_mic: 0,
            pret_animal_mare: 0,

            pret_total: pretTotal,

            tur_retur: turReturVechi,
        },

        created: function () {
            this.getOrasePlecareInitial()
            this.getOraseSosireInitial()
            this.getPreturi()
        },
        methods: {
            getOrasePlecareInitial: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_plecare',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_plecare = response.data.raspuns;
                    });
            },
            getOrasePlecare: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_plecare',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_plecare = '';
                        // app1.orase_sosire = '';
                        app1.oras_plecare = 0;
                        // app1.oras_sosire = 0;
                        app1.pret_adult = 0;
                        app1.pret_copil = 0;
                        app1.pret_animal_mic = 0,
                        app1.pret_animal_mare = 0,

                        app1.orase_plecare = response.data.raspuns;
                    });
            },
            getOraseSosireInitial: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = response.data.raspuns;
                    });
            },            
            getOraseSosire: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = '';
                        app1.oras_sosire = 0;
                        app1.pret_adult = 0;
                        app1.pret_copil = 0;
                        app1.pret_animal_mic = 0,
                        app1.pret_animal_mare = 0,

                        app1.orase_sosire = response.data.raspuns;
                        // app1.getPretTotal();
                    });
                // app2.getPretTotal();
            },
            getPreturi: function () {
                if ((typeof this.oras_sosire !== 'undefined') && (this.oras_sosire !== 0) && (typeof this.oras_plecare !== 'undefined') && (this.oras_plecare !== 0)) {
                    if (this.traseu == 1){
                        var oras = this.oras_sosire
                    } else if (this.traseu == 2){
                        var oras = this.oras_plecare
                    }
                    axios.get('/orase_rezervari', {
                        params: {
                            request: 'preturi',
                            oras,
                            // oras_plecare: this.oras_plecare,
                            // oras_sosire: this.oras_sosire,
                            tur_retur: this.tur_retur
                        }
                    })
                        .then(function (response) {
                            app1.pret_adult = response.data.pret_adult;
                            app1.pret_copil = response.data.pret_copil;
                            app1.pret_animal_mic = response.data.pret_animal_mic;
                            app1.pret_animal_mare = response.data.pret_animal_mare;
                            // Vue.set(app2.pret_adult);
                            // Vue.set(app2.pret_copil = response.data.pret_copil);
                            app1.getPretTotal();
                        });
                    // app2.getPretTotal();
                }                
            },
            getPretTotal() {
                this.pret_total = 0;
                if (!isNaN(this.nr_adulti) && (this.nr_adulti > 0)) {
                    this.pret_total = this.pret_total + this.pret_adult * this.nr_adulti
                }
                if (!isNaN(this.nr_copii) && (this.nr_copii > 0)) {
                    this.pret_total = this.pret_total + this.pret_copil * this.nr_copii
                }
                if (!isNaN(this.nr_animale_mici) && (this.nr_animale_mici > 0)) {
                    this.pret_total = this.pret_total + this.pret_animal_mic * this.nr_animale_mici
                }
                if (!isNaN(this.nr_animale_mari) && (this.nr_animale_mari > 0)) {
                    this.pret_total = this.pret_total + this.pret_animal_mare * this.nr_animale_mari
                }
            },
        }
    });
}

if (document.querySelector('#transport-colete')) {
    const app1 = new Vue({
        el: '#transport-colete',
        data: {
            traseu: traseuVechi,
            active: "active",
            oras_plecare: orasPlecareVechi,
            orase_plecare: '',
            oras_sosire: orasSosireVechi,
            orase_sosire: '',

            numar_colete: numarColeteVechi,
        },

        created: function () {
            this.getOrasePlecareInitial()
            this.getOraseSosireInitial()
        },
        methods: {
            getOrasePlecareInitial: function () {
                axios.get('/orase_colete', {
                    params: {
                        request: 'orase_plecare',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_plecare = response.data.raspuns;
                    });
            },
            getOrasePlecare: function () {
                axios.get('/orase_colete', {
                    params: {
                        request: 'orase_plecare',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_plecare = '';
                        app1.oras_plecare = 0;

                        app1.orase_plecare = response.data.raspuns;
                    });
            },
            getOraseSosireInitial: function () {
                axios.get('/orase_colete', {
                    params: {
                        request: 'orase_sosire',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = response.data.raspuns;
                    });
            },
            getOraseSosire: function () {
                axios.get('/orase_colete', {
                    params: {
                        request: 'orase_sosire',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = '';
                        app1.oras_sosire = 0;

                        app1.orase_sosire = response.data.raspuns;
                        
                    });
            },
        }
    });
}

if (document.querySelector('#adauga-rezervare-aeroport')) {
    const app1 = new Vue({
        el: '#adauga-rezervare-aeroport',
        data: {
            traseu: traseuVechi,
            active: "active",

            nr_adulti: nrAdultiVechi,
            nr_copii: nrCopiiVechi,

            pret_adult: 0,
            pret_copil: 0,

            pret_total: pretTotal,

            tur_retur: turReturVechi,
        },

        created: function () {
            this.getPreturi()
            this.getPretTotal()
        },
        methods: {
            getPreturi: function () {
                if (this.tur_retur === false) {
                    this.pret_adult = 70,
                    this.pret_copil = 40
                } else if (this.tur_retur === true) {
                    if (this.nr_adulti < 5) {
                        this.pret_adult = 120,
                        this.pret_copil = 80                        
                    } else if (this.nr_adulti > 4) {
                        this.pret_adult = 100,
                        this.pret_copil = 80 
                    }
                }
            },
            getPretTotal() {
                this.pret_total = 0;
                if (!isNaN(this.nr_adulti) && (this.nr_adulti > 0)) {
                    this.pret_total = this.pret_total + this.pret_adult * this.nr_adulti
                }
                if (!isNaN(this.nr_copii) && (this.nr_copii > 0)) {
                    this.pret_total = this.pret_total + this.pret_copil * this.nr_copii
                }
                if (!isNaN(this.nr_animale_mici) && (this.nr_animale_mici > 0)) {
                    this.pret_total = this.pret_total + this.pret_animal_mic * this.nr_animale_mici
                }
                if (!isNaN(this.nr_animale_mari) && (this.nr_animale_mari > 0)) {
                    this.pret_total = this.pret_total + this.pret_animal_mare * this.nr_animale_mari
                }
            },
        }
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

if (document.querySelector('#vanzari')) {
    const app = new Vue({
        el: '#vanzari',
        methods: {
            formfocus() {
                document.getElementById("cod_de_bare").focus();
            }
        },
        mounted() {
            this.formfocus()
        }
    });
}
