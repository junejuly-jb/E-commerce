<template>
    <v-app>
        <div id="sidebar-wrapper" class="border-right">
            <div class="sidebar-heading text-center">Salamat Shopee</div>
            <v-container class="py-5 text-center">
                <v-avatar
                color="primary"
                size="128"
                >
                    <span class="white--text headline">{{user.default_profile}}</span>
                </v-avatar>
                <div class="pt-3">
                    <h5>{{user.name}}</h5>
                    <small>{{user.usertype}}</small>
                </div>
            </v-container>
            <div class="list-group list-group-flush">
                <router-link to="/admindashboard" class="list-group-item">Dashboard</router-link>
                <router-link to="/admin_profile" class="list-group-item">Profile</router-link>
                <router-link to="/admin_user_list" class="list-group-item">Users</router-link>
                <router-link to="/admin_store_list" class="list-group-item">Stores</router-link>
                <router-link to="/admin_store_requests" class="list-group-item">Store Requests</router-link>
                <router-link to="/admin_transaction_logs" class="list-group-item">Transaction Logs</router-link>
                
            </div>
        </div>
    </v-app>
</template>
<script>
export default {
    props: ['user'],
    methods:{
        loadJS(){
            const plugin = document.createElement("script");
            plugin.setAttribute(
                "src",
                "./js/sidebar.js"
            );
            plugin.async = true;
            document.head.appendChild(plugin);
        }
    },
    mounted() {
        this.loadJS()
    }
}
</script>