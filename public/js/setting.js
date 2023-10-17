let setting = new Vue({
    el : '#setting',
    data : {
        darkModeStatus : false,
    },
    mounted() {
        const darkModeStored = localStorage.getItem('darkMode');
        if(darkModeStored!==null) {
            this.darkModeStatus = JSON.parse(darkModeStored);
        }
    },
    methods: {
        toggleDarkMode() {
            this.darkModeStatus = !(this.darkModeStatus);
            localStorage.setItem('darkMode', JSON.stringify(this.darkModeStatus));
        },
        isCurrentRoute(route){
            return window.location.pathname === route;
        },
    },
})
