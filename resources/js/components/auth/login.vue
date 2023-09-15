<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="login-title">Log in</h2>
                <form class="login-form px-5" @submit.prevent="submit">
                    
                    <div>
                        <label for="email">Email </label>
                        <input
                            id="email"
                            type="email"
                            placeholder="Email"
                            name="email"
                            v-model="form.email"
                            required
                            />
                    </div>

                    <div>
                        <label for="password">Password </label>
                        <input
                            id="password"
                            type="password"
                            placeholder="password"
                            name="password"
                            v-model="form.password"
                            required
                            />
                    </div>

                    <button class="btn btn--form" type="submit" value="Log in">
                        Log in
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
            "login",
        ]),

        async submit() {
            this.processing = true
            this.login(this.form).then((response) => {
                this.$notify({
                    group: 'notif',
                    type: 'success',
                    title: 'Authentication Success',
                    text: `Successfully Login as ${response.data.user.name}` 
                });
                this.$router.push({ name: 'Board' });

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