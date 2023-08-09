<template>
    <Menu
        @change-route="updateRoute"
        :routes="routes"
    >
    </Menu>
    <div class="route" v-for="route in routes">
        <component
            :is="route"
            v-if="activeRoute === route"
            @change-route="updateRoute"
        >
        </component>
    </div>
</template>

<script>
import Overview from "./Home/Overview.vue";
import Register from "./Login/Register.vue";
import Login from "./Login/Login.vue";
import Menu from "./Partials/Menu.vue";
import routes from "../guestroutes.json";
export default {
    data () {
        return {
            activeRoute: 'overview',
            routes: routes
        }
    },
    components: {
        Overview,
        Register,
        Login,
        Menu
    },
    methods: {
        updateRoute (routeName) {
            this.activeRoute = routeName;
        }
    }
}
</script>
