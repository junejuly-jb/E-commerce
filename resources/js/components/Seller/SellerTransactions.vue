<template>
    <v-app>
        <div class="d-flex page" id="wrapper">
            <sellersidebar v-bind:user="user"></sellersidebar>
            <div id="page-content-wrapper">
                <sellernav v-bind:user="user"></sellernav>
                <div class="container">
                    <div class="dashHeader">
                        <span class="discover">Seller</span><span class="daily"> Transactions</span>
                    </div>
                </div>
            </div>
        </div>
    </v-app>
</template>
<script>
export default {
    data: () => ({
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        },
       
    }),
    methods:{
        getUser(){
            var user = JSON.parse(localStorage.getItem('user'))
            this.user = user

            var name = user.name

            var getInitials = function (name) {
            var parts = name.split(' ')
            var initials = ''
            for (var i = 0; i < parts.length; i++) {
                if (parts[i].length > 0 && parts[i] !== '') {
                    initials += parts[i][0]
                }
            }
                return initials
            }
            this.user.default_profile = getInitials(name);
        },
       
    },
    mounted(){
        this.getUser()
    }
}
</script>