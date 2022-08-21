<template>
    <div class="container mx-auto">
        <form @submit.prevent="login">
            <div>
                <label for="email">email</label>
                <input type="email" v-model="form.email" name="email" id="email">
                <div class="text-red 500" mt-2 text-sm v-if="errors['email']"> {{ errors['email'] [0] }} </div>
            </div>
             <div>
                <label for="password">password</label>
                <input type="password" v-model="form.password" name="password" id="password">
                 <div class="text-red 500" mt-2 text-sm v-if="errors['password']"> {{ errors['password'] [0] }} </div>
            </div>
            <button>Login</button>
        </form>
    </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { reactive, ref } from 'vue';
export default {
    setup () {
        const errors = ref([])
        const form = reactive({
            email: '',
            password: '',
        })


        const login = async () => {
            try{
                await store.dispatch("auth/login", form)
                router.replace("/")
            }catch (e) {
                errors.value = e.response.data.errors;
            }
        }
            return {login, form, errors}
    }

}
</script>

<style>

</style>