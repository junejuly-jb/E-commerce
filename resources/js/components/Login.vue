<template>
    <v-app>
        <!-- <v-card tile>
            <v-toolbar flat>
                <v-toolbar-title>
                    Login Page
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon :to="{path: '/'}">
                    <v-icon>mdi-reply</v-icon>
                </v-btn>
                <router-link to="/register" tag="v-btn">Register</router-link>
            </v-toolbar>
        </v-card> -->
        <v-container class="h-100 d-flex justify-content-center align-items-center">
            <v-card class="mx-auto rounded-xl" width="450" tile>
                <v-card-title class="headline">
                    <div class="text-primary"> Login </div>
                </v-card-title>
                    <v-container>
                            <div class="">
                                <v-text-field
                                v-model="form.email"
                                label="Enter Email Address"
                                prepend-icon="mdi-account"
                                hint="Email must contains '@'" 
                                :rules="[rules.email_val1, rules.email_val2]"
                                clearable>
                                </v-text-field>
                            </div>
                            <v-text-field
                                v-model="form.password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required, rules.min]"
                                prepend-icon="mdi-lock"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Enter Password"
                                hint="At least 6 characters"
                                counter
                                @click:append="show1 = !show1"
                            ></v-text-field>
                            <div class="text-center">
                                <v-card-text>
                                    <span>Need account? &nbsp; |&nbsp;&nbsp; </span><router-link to="/register">Register</router-link>
                                </v-card-text>
                            </div>
                    </v-container>
                    <!-- <div class="container"> -->
                        <v-divider class="mx-5"></v-divider>
                    <!-- </div> -->
                    <v-container class="text-right">
                        <v-btn color="primary" @click="login">
                            <span v-if="loading">
                                <v-progress-circular
                                :width="3"
                                color="blue lighten-5"
                                indeterminate
                                ></v-progress-circular>
                            </span>
                            <span v-else>
                                Login
                            </span>
                        </v-btn>
                    </v-container>
                
                <div class="py-2"></div>
            </v-card>

            <!-- snackbar  -->
            <v-snackbar
            v-model="snack"
            :multi-line="multiLine"
            left
            >
            {{ message }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                    color="red"
                    text
                    v-bind="attrs"
                    @click="snack= false"
                    >
                    Close
                    </v-btn>
                </template>
            </v-snackbar>
            <!-- end snackbar  -->
        </v-container>
    </v-app>    
</template>
<script>
export default {
    data: () => ({
        loading: false,
        show1: false,
        snack: false,
        multiLine: true,
        message: '',
        rules: {
            required: value => !!value || 'Required.',
            validation_2: value => (value && value.length >= 3) || 'Min 3 characters',
            email_val1: v => !!v || 'E-mail is required',
            email_val2: v => /.+@.+/.test(v) || 'E-mail must be valid',
            min: v => v.length >= 6 || 'Min 6 characters',
        },
        form: {
            email: '',
            password: '',
        }
    }),

    methods: {
        async login(){
            this.loading = true
            this.$Progress.start()
            await this.$http.post('api/login', this.form)
            .then((res) => {
                if(res.body.message == 'fail'){
                    this.$Progress.start()
                    this.message = 'Login failed'
                    this.snack = true
                    this.$Progress.fail()
                }
                else if(res.body.message == 'inactive'){
                    this.$Progress.start()
                    this.message = 'User is inactive, Please contact admin for more information'
                    this.snack = true
                    this.$Progress.fail()
                }
                else if(res.body.user['usertype'] == 'user'){
                    this.$Progress.start()
                    this.$auth.setToken(res.body.token['accessToken'], res.body.user['usertype'], JSON.stringify(res.body.user))
                    this.$router.push('/userdashboard')
                    this.$Progress.finish()
                }
                else if(res.body.user['usertype'] == 'seller'){
                    this.$Progress.start()
                    this.$auth.setToken(res.body.token['accessToken'], res.body.user['usertype'], JSON.stringify(res.body.user))
                    this.$router.push('/sellerdashboard')
                    this.$Progress.finish()
                }
                else{
                    this.$Progress.start()
                    this.$auth.setToken(res.body.token['accessToken'], res.body.user['usertype'], JSON.stringify(res.body.user))
                    this.$router.push('/admindashboard')
                    this.$Progress.finish()
                }
            })
            .finally(() => (this.loading = false))
        }
    }
}
</script>