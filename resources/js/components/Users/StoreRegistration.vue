<template>
    <v-app>
        <usernav v-bind:user="user"></usernav>
        <v-container class="card-notifier">
            <v-stepper v-model="e1">
            <v-stepper-header>
            <v-stepper-step
                :complete="e1 > 1"
                step="1"
            >
                User Information
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
                :complete="e1 > 2"
                step="2"
            >
                Store Details
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">
                All caught up!
            </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
            <v-stepper-content step="1">
                
                <v-container>
                    <div class="pb-4">   
                        Please fill up this fields to continue
                    </div>
                    <v-text-field
                        v-model="user.name"
                        prepend-icon="mdi-account-outline"
                        label="Store Owner"
                        disabled
                    ></v-text-field>
                    <v-text-field
                        v-model="user.email"
                        prepend-icon="mdi-email-outline"
                        name="email"
                        label="Email Address"
                        disabled
                    ></v-text-field>
                    <v-text-field
                        :rules="[rules.required]"
                        name="address"
                        v-model="userForm.address"
                        prepend-icon="mdi-map-marker-radius-outline"
                        label="Address"
                    ></v-text-field>
                    <v-text-field
                        v-model="userForm.contact"
                        prepend-icon="mdi-phone-outline"
                        maxlength="11"
                        counter="11"
                        type="number"
                        :rules="[rules.required, rules.min]"
                        label="Contact"
                    ></v-text-field>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                v-model="userForm.gender"
                                :items="gender"
                                :rules="[rules.required]"
                                label="Gender"
                                placeholder="Select..."
                                prepend-icon="mdi-gender-male-female"
                            ></v-autocomplete>
                        </v-col>
                        <v-col>
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="date"
                                    label="Birthday"
                                    prepend-icon="mdi-calendar"
                                    :rules="[rules.required]"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                                </template>
                                <v-date-picker
                                ref="picker"
                                v-model="date"
                                max="2002-01-01"
                                min="1950-01-01"
                                @change="save"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                </v-container>

                <v-btn
                color="primary"
                @click="firstButton"
                >
                Continue
                </v-btn>

                <!-- <v-btn text @click="e1 = 1">
                Back
                </v-btn> -->
            </v-stepper-content>

            <v-stepper-content step="2">
                <v-container>
                    <v-text-field
                        v-model="userForm.storeName"
                        prepend-icon="mdi-store"
                        label="Store Name"
                        :rules="[rules.required]"
                    ></v-text-field>
                    <v-text-field
                        v-model="userForm.storeAddress"
                        prepend-icon="mdi-map-marker-radius-outline"
                        label="Store Address (for pick-up)"
                        :rules="[rules.required]"
                    ></v-text-field>
                    <v-text-field
                        v-model="userForm.storeWebsite"
                        prepend-icon="mdi-web"
                        label="Social Media Link (atleast one)"
                        :rules="[rules.required]"
                    ></v-text-field>
                    <v-textarea
                        prepend-icon="mdi-comment-quote-outline"
                        :rules="[rules.required]"
                        label="Short Description"
                        v-model="userForm.storeDescription"
                        >
                    </v-textarea>
                </v-container>

                <v-btn
                color="primary"
                @click="secondButton"
                >
                Continue
                </v-btn>

                <v-btn text @click="e1 = 1">
                Cancel
                </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
                <v-container>
                    <div class="text-center pb-3">
                        <span class="emoji">🥳</span><br><br>
                        <span>Thanks for joining!</span>
                        <h5>Your registration is complete. Please wait for administrator's response.</h5> 
                    </div>
                </v-container>

                <v-btn
                color="info"
                class="btn-links"
                to="/userdashboard">
                Back
                </v-btn>

                <!-- <v-btn text>
                Cancel
                </v-btn> -->
            </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
        </v-container>

        <!-- snackbar -->
        <v-snackbar
            v-model="snackbar"
            >
            {{ message }}

            <template v-slot:action="{ attrs }">
                <v-btn
                color="pink"
                text
                v-bind="attrs"
                @click="snackbar = false"
                >
                Close
                </v-btn>
            </template>
        </v-snackbar>
        <!-- snackbar -->

        <!-- dialog prompter  -->
        <v-dialog
        v-model="dialog"
        width="500"
        persistent
        >
        <v-card>
            <v-card-title class="headline red darken-1 text-white">
            Warning!
            </v-card-title>

            <v-container>
                <v-card-text>
                    You have a pending store registration request. <br><br>
                    <span class="text-danger">NOTE:</span> 1 store per account only. 
                </v-card-text>
            </v-container>
            <v-divider></v-divider>

            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="primary"
                text
                @click="dialog = false"
                to="/userdashboard"
            >
                Okay
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-app>
</template>
<script>
export default {
    data: () => ({
        user: {
            name: '',
            email: '',
            address: '',
            contact: '',
        },
        dialog: false,
        e1: 1,
        gender: ['male', 'female'],
        date: null,
        rules: {
            required: value => !!value || 'Required.',
            min: v => v.length >= 11 || 'Min 11 characters',
        },
        snackbar: false,
        message: '',
        menu: false,
        userForm: {
            id: '',
            address: '',
            contact: '',
            gender: '',
            birthday: '',
            storeName: '',
            storeAddress: '',
            storeWebsite: '',
            storeDescription: '',
        },
    }),
    methods: {
        getUser(){
            var user = JSON.parse(localStorage.getItem('user'))
            this.user = user
        },
        save (date) {
            this.$refs.menu.save(date)
            this.userForm.birthday = date
        },
        firstButton(){
            if(this.userForm.address == '' || this.userForm.contact == '' || this.userForm.gender == '' || this.userForm.birthday == ''){
            
                this.snackbar = true
                this.message = 'Please fill up the form correctly'
                console.log(this.userForm)
            }
            else{
                this.e1 = 2
                console.log(this.userForm)
            }
        },
        async secondButton(){
            if(this.userForm.storeName == '' || this.userForm.storeAddress == '' || this.userForm.storeWebsite == '' || this.userForm.storeDescription == ''){
            
                this.snackbar = true
                this.message = 'Please fill up the form correctly'
                console.log(this.userForm)
            }
            else{
                var user = JSON.parse(localStorage.getItem('user'))
                this.userForm.id = user.id
                await this.$http.post('api/storeRegistration', this.userForm, {
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                })
                .then((res) => {
                    this.e1 = 3
                    this.snackbar = true;
                    this.message = res.body.message
                    console.log(this.userForm)
                })
            }
            // this.e1 = 3
        },
        checkIfExists(){
            var user = JSON.parse(localStorage.getItem("user"))
        
            this.$http.get('api/checkIfExists/' + user.id, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                if(res.body.message == 'exists'){
                    this.dialog = true
                }
            })
        }
    },
    watch: {
      menu (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    },
    
    mounted(){
        this.getUser()
        this.checkIfExists()
    }
}
</script>