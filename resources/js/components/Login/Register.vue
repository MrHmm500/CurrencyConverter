<template>
    <div class="row">
        <div class="col-sm-2 mb-4 mt-4">
            name:
        </div>
        <div class="col-sm-10 mb-4 mt-4">
            <input v-model="user.name" type="text" class="w-100" />
        </div>
        <div class="col-sm-2 mb-4">
            username:
        </div>
        <div class="col-sm-10 mb-4">
            <input type="text" v-model="user.username" class="w-100" />
        </div>
        <div class="col-sm-2 mb-4">
            email:
        </div>
        <div class="col-sm-10 mb-4">
            <input type="email" v-model="user.email" class="w-100" />
        </div>
        <div class="col-sm-2 mb-4">
            password:
        </div>
        <div class="col-sm-10 mb-4">
             <input type="password" v-model="user.password" class="w-100" />
        </div>
        <div class="col-sm-2 mb-4">
            <input @click="registerUser()"  type="button" value="register"/>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Register',
    data () {
        return {
            'user': {
                'name': '',
                'username': '',
                'email': '',
                'password': '',
                'type': 0,
            },
            'errors': '',
        }
    },
    methods: {
        registerUser() {
            axios.post('/register', this.user).then((response) => {
                if (response.status === 200) {
                    location.reload();
                }
                this.errors = response.message
            })
        }
    }
}
</script>
