<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar></sidebar>
            <div id="page-content-wrapper">
                <navbar></navbar>
                <div class="container">
                    <h1 class="mt-4">Admin Profile</h1>
                    <div class="row">
                        <div class="col-lg">
                            <v-container>
                                <v-card elevation="2" tile>
                                    <v-card-title class="headline">
                                        Administrator Information
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <div class="text-center py-2">
                                        <v-avatar
                                        color="primary"
                                        size="128"
                                        >DA</v-avatar>
                                    </div>
                                    <div class="text-center pb-5 pt-5">
                                        <h3>User Name</h3>
                                        <span>usertype</span>
                                    </div>
                                    
                                    <div class="row text-center py-5">
                                        <div class="col-lg">
                                            <div class="text-center">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                                        <polyline points="3 7 12 13 21 7" />
                                                    </svg>
                                                </div>
                                                <div> Email@gmail.com</div>
                                            </div>
                                        </div>
                                        <div class="col-lg">asd</div>
                                        <div class="col-lg">asd</div>
                                    </div>
                                </v-card>
                            </v-container>
                        </div>
                        <div class="col-lg">
                            <v-container>
                                <v-card elevation="2" tile>
                                    <v-card-title class="headline">
                                        Edit Information
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        Please provide your correct credentials
                                    </v-card-text>
                                </v-card>
                            </v-container>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </v-app>
</template>
<script>
export default {
    data: () => ({
    
    }),
}
</script>