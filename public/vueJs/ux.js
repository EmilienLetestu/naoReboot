
new Vue({
    el: '#wrapper',
    data:{
        show: null,
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
        }
    }
});