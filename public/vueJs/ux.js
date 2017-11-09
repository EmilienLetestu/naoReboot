
new Vue({
    el: '#wrapper',
    data:{
        show: null,
        nav: null,
        seen: null,
        name:'',
        surname:'',
        pswd:'',
        email:'',
        submit: false,
        confirmPswd:''
    },
    computed:{
        missingName: function () {
            return (
                this.name === ''||
                this.name.length < 3
            )
        },
        missingSurname: function() {
            return (
                this.surname === ''||
                this.surname.length < 3
            )
        },
        missingPswd: function () {
            return (
                this.pswd === ''||
                this.pswd.length < 6 ||
                this.pswd.length > 30
            )
        },
        missingEmail: function() {
            return this.email === ''
        },
        matchLess: function() {
            return(
                this.confirmPswd !== this.pswd ||
                this.confirmPswd === ''
            )
        }

    },
    methods:{
        open:function () {

            this.seen = true;

        },
        close:function () {
            this.seen = false;
        },
        validateRegister: function(event) {
            this.submit = true;
            if(this.missingName||this.missingSurname||this.missingPswd||this.missingEmail)
                event.preventDefault();
        },
        validateLogin: function (event) {
            this.submit = true;
            if(this.missingPswd||this.missingEmail)
                event.preventDefault();
        },
        validateResetPswd: function (event) {
            this.submit = true;
            if(this.missingPswd||this.matchLess)
                event.preventDefault();
        },
        validateChangePswd: function (event) {
            this.submit = true;
            if(this.missingPswd||this.matchLess)
                event.preventDefault();
        },
        pictNumber: function (btn) {
            this.seen = true;
            if(btn === 1){
               document.getElementById('pictRef').value = "1";
            }
            if(btn === 2){
                document.getElementById('pictRef').value = "2";
            }
            if(btn === 3){
                document.getElementById('pictRef').value = "3";
            }
        }
    }
});


