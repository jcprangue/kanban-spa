<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="login-title">Register Account</h2>
                <form class="login-form px-5" @submit.prevent="submit">

                    <div>
                        <label for="firstName">First Name</label>
                        <input id="first_name" type="text" placeholder="First Name" name="first_name"
                            v-model="form.first_name" required />
                    </div>

                    <div>
                        <label for="lastName">Last Name</label>
                        <input id="last_name" type="text" placeholder="Last Name" name="last_name" v-model="form.last_name"
                            required />
                    </div>



                    <div>
                        <label for="email">Email </label>
                        <input id="email" type="email" placeholder="Email" name="email" v-model="form.email" required />
                    </div>

                    <div>
                        <label for="password">Password </label>
                        <input id="password" type="password" placeholder="password" name="password" v-model="form.password"
                            required />
                    </div>

                    <button class="btn btn--form" type="submit" value="Log in">
                        Register
                    </button>

                </form>
            </div>
        </div>


    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    name: "login",
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
                password: ''
            },
            processing: false
        }
    },
    computed: {
        ...mapGetters("auth", [
            "authenticated",
            "user",
        ]),
    },
    methods: {
        ...mapActions("auth", [
            "register",
        ]),

        async submit() {
            this.processing = true
            this.register(this.form).then((response) => {
                this.$notify({
                    group: 'notif',
                    type: 'success',
                    title: 'System Notification',
                    text: response.data.message
                });
                this.$router.push({ name: 'Login' });

            }).catch(error => {
                if (error.response && error.response.data && error.response.data.message) {
                    const errorMessage = error.response.data.message;
                    this.$notify({
                        group: 'notif',
                        type: 'error',
                        title: 'Authentication Failed',
                        text: errorMessage
                    });
                }
            });


        },

    }
}
</script>