
new Vue({
    el: '#app',
    data:{
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