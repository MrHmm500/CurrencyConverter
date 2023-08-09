<template>
    <div class="row justify-content-center">
        <div class="menuItem col-sm" v-for="route in routes">
            <div
                @click="updateRoute(route)"
            >
                {{ route }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Menu',
    props: {
        'routes': [],
    },
    methods: {
        updateRoute (routeName) {
            this.$emit('change-route', routeName)
        }
    }
}
</script>
