<template>
    <v-app>
        <v-container>
            <v-card elevation="2">
                <v-card-title>
                    <h1>Welcome!</h1>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vitae risus nec justo venenatis tempor sed sit amet dui. Maecenas molestie dictum tellus, eu ornare tortor tincidunt id. Sed eleifend sodales nunc a aliquet.
                    Nunc varius odio eget justo efficitur, at viverra dolor viverra. Fusce nec dictum lacus. Suspendisse potenti.    
                </v-card-text>
                <v-card-text>
                    Nunc varius odio eget justo efficitur, at viverra dolor viverra. Fusce nec dictum lacus. Suspendisse potenti.    
                </v-card-text>
                <v-container>
                    <router-link to="/login" tag="v-btn"> Login </router-link>
                    <router-link to="/register" tag="v-btn"> Register </router-link>
                </v-container>
                <v-card-text>
                    Want to start online selling with us? Click the button below to start!
                </v-card-text>
                <v-container>
                    <router-link to="/" tag="v-btn"> Register Your Store </router-link>
                </v-container>
            </v-card>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
