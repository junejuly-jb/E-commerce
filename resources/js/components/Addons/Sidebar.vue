<template>
    <v-app>
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center">Salamat Shopee</div>
            <div class="list-group list-group-flush">
                <router-link to="/admindashboard" class="list-group-item list-group-item-action">Dashboard</router-link>
                <router-link to="/admin_profile" class="list-group-item list-group-item-action">Profile</router-link>
                <router-link to="/admin_user_list" class="list-group-item list-group-item-action">Users</router-link>
                <router-link to="/store_list" class="list-group-item list-group-item-action">Store</router-link>
                <router-link to="/admin_requests" class="list-group-item list-group-item-action">Requests</router-link>
                <router-link to="/admin_transaction_logs" class="list-group-item list-group-item-action">Transaction Logs</router-link>
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