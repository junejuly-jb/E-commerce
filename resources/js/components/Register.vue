<template>
    <v-app>
        <v-container class="h-100 d-flex justify-content-center align-items-center">
            <v-card class="mx-auto mt-5 rounded-xl" width="500" tile>
                <v-card-title class="headline">
                    <div class="text-primary"> Register </div>
                </v-card-title>
                
                    <v-container>
                            <div class="">
                                <v-text-field
                                prepend-icon="mdi-account-outline"
                                v-model="form.name"
                                hint="Must be 3 characters and above" 
                                label="Enter Name"
                                :rules="[rules.required, rules.validation_2]"
                                >
                                </v-text-field>
                            </div>
                            <div class="">
                                <v-text-field
                                prepend-icon="mdi-email-outline"
                                v-model="form.email"
                                label="Enter Email Address"
                                hint="Email must contains '@'" 
                                :rules="[rules.email_val1, rules.email_val2]"
                                clearable>
                                </v-text-field>
                            </div>
                            <v-text-field
                                v-model="form.password"
                                prepend-icon="mdi-lock-outline"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required, rules.min]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Enter Password"
                                hint="At least 6 characters"
                                counter
                                @click:append="show1 = !show1"
                            ></v-text-field>
                            <v-text-field
                                prepend-icon="mdi-account-check"
                                v-model="form.cPassword"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required, rules.min]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Confirm password"
                                hint="At least 6 characters"
                                counter
                                @click:append="show1 = !show1"
                            ></v-text-field>
                    </v-container>
                    <div class="text-center">
                        <span>Already have an account? &nbsp;&nbsp; |</span> <router-link to="/login">&nbsp;&nbsp; Login</router-link>
                    </div>
                    <v-divider class="mx-5"></v-divider>
                    <v-container class="text-right">
                        <v-btn v-if="loading" color="light-blue lighten-1">
                            <v-progress-circular
                            :width="3"
                            color="blue lighten-5"
                            indeterminate
                            ></v-progress-circular>
                        </v-btn>
                        
                        <v-btn v-else color="light-blue lighten-1" @click="register">Register</v-btn>
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
// import { bus } from '../app';

export default {
    data: () => ({
        show1: false,
        loading: false,
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
            name: '',
            email: '',
            password: '',
            cPassword: '',
        },
        // busMessage: 'Logged in'
    }),
    methods:{
        async register(){
            this.loading = true
            if(this.form.password != this.form.cPassword){
                this.message = '❌ Password mismatch'
                this.snack = true
                this.loading = false
            }
            else{
                await this.$http.post('api/register', this.form)
                .then((res) => {
                    // bus.$emit('registered', this.busMessage)
                    this.message = res.data.message + ' Redirecting ...'
                    this.snack = true
                    console.log(res.data.data)
                    setTimeout(() => {
                        this.$router.push('/login')
                    }, 3000)
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally( () => (this.loading = false))
            }
        },
    }
}
</script>