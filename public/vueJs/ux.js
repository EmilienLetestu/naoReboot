
new Vue({
    el: '#wrapper',
    data:{
        show: null,
        nav: false,
        seen: null,
        reportList: null,
        filter: null,
        name:'',
        surname:'',
        pswd:'',
        email:'',
        submit: false,
        confirmPswd:'',
        info: null,
        map: null,
        bird: null,
        article1:null,
        article2:null,
        article3:null,
        article4:null,
        article5:null,
        article6:null,
        article7:null,
        article8:null,
        article9:null,
        article10:null,
        article11:null,
        article12:null,
        cmt:null
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
        },
        showInfo: function(btn){
          this.info = btn;
        },

        showMap: function (btn) {
           this.map = btn;
           this.bird = btn;
        },

        offcanvas:function () {
            this.nav == false ? this.nav = true : this.nav = false;
            document.getElementById('adminNav').style.width = "250px";
            if(this.nav == true)
            {
                document.getElementById('adminNavTrigger').style.left = "250px";
                document.getElementById('adminNavBtn').classList.remove('fa-caret-right');
                document.getElementById('adminNavBtn').classList.add('fa-caret-left');
            } else{
                document.getElementById('adminNavTrigger').style.left = "0";
                document.getElementById('adminNavBtn').classList.remove('fa-caret-left');
                document.getElementById('adminNavBtn').classList.add('fa-caret-right');
            }

        }

    }
});


