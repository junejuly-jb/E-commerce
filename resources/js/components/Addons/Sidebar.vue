<template>
    <v-app>
        <div id="sidebar-wrapper" class="border-right">
            <div class="sidebar-heading text-center">Salamat Shopee</div>
            <div class="list-group list-group-flush">
                <router-link to="/admindashboard" class="list-group-item">Dashboard</router-link>
                <router-link to="/admin_profile" class="list-group-item">Profile</router-link>
                <router-link to="/admin_user_list" class="list-group-item">Users</router-link>
                <router-link to="/store_list" class="list-group-item">Store</router-link>
                <router-link to="/admin_requests" class="list-group-item">Requests</router-link>
                <router-link to="/admin_transaction_logs" class="list-group-item">Transaction Logs</router-link>
            </div>
        </div>
    </v-app>
</template>
<script>
export default {
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