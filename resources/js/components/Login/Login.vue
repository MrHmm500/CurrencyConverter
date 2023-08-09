<template>
    {{errors}}
    <div class="row">
        <div class="col-sm-2 mt-4">
            email:
        </div>
        <div class="col-sm-10 mt-4">
            <input v-model="user.email" type="email" class="w-100" />
        </div>
        <div class="col-sm-2 mt-4">
            password:
        </div>
        <div class="col-sm-10 mt-4">
            <input v-model="user.password" type="password" class="w-100" />
        </div>
        <div class="col-sm-2 mt-4">
            <input @click="login" type="button" value="login"/>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
        return {
            'user': {
                'email': '',
                'password': '',
            },
            'errors': '',
        }
    },
    methods: {
        login() {
            axios.post('/login', this.user).then((response) => {
                if (response.status === 200) {
                    location.reload()
                }
                this.errors = response.message
            })
        }
    }
}
</script>
