
new Vue({
    el: '#wrapper',
    data:{
        show: null,
        seen: null
    },
    methods:{
        open:function () {

            this.seen = true;

        },
        close:function () {
            this.seen = false;
        }

    }

});