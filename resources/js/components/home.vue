<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="#">Kanban</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/board" class="nav-link">Board</router-link>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarNav">
                    <ul class="navbar-nav">

                        <template v-if="!authenticated">
                            <li class="nav-item active">
                                <router-link to="/login" class="nav-link">Login</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/register" class="nav-link">Register</router-link>
                            </li>
                        </template>

                        <template v-else>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)">{{ user.name }}</a>
                            </li>
                            <li class="nav-item">
                                <router-link to="/login" @click.native="clearState" class="nav-link">Logout</router-link>
                            </li>
                        </template>
                    </ul>
                </div>

            </div>
        </nav>

        <notifications group="notif" />

        <div class="container">
            <router-view> </router-view>
        </div>
    </div>
</template>
 
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    name: "home",
    computed: {
        ...mapGetters("auth", [
            "authenticated",
            "user",
        ]),
    },
    mounted() {


    },
    methods: {
        ...mapActions("auth", [
            "logout",
        ]),

        clearState() {
            this.logout();
            this.$router.push({ name: 'createTask' })
        }

    }

}
</script>