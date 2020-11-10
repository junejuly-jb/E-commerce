<template>
    <v-app>
        <div id="sidebar-wrapper">
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
                <router-link to="/sellerdashboard" class="list-group-item">Dashboard</router-link>
                <router-link to="/seller_inventory" class="list-group-item">Inventory</router-link>
                <router-link to="/seller_purchase_request" class="list-group-item">Purchase Request</router-link>
                <router-link to="/seller_transactions" class="list-group-item">Transactions</router-link>
                <router-link to="/seller_announcements" class="list-group-item">Announcements</router-link>
                <router-link to="/seller_transaction_logs" class="list-group-item">Transaction Logs</router-link>
                <router-link to="/seller_product_reviews" class="list-group-item">Reviews</router-link>
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
<style scoped>
    .router-link-active{
        background-color: dodgerblue !important;
        color: white !important;
    }
</style>