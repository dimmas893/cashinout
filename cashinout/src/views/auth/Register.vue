<template>
    <div class="container mx-auto">
        <form @submit.prevent="register">
            <div>
                <label for="email">email</label>
                <input type="email" v-model="form.email" name="email" id="email">
                 <div class="text-red 500" mt-2 text-sm v-if="errors['email']"> {{ errors['email'] [0] }} </div>
            </div>
            <div>
                <label for="name">name</label>
                <input type="text" v-model="form.name" name="name" id="name">
                 <div class="text-red 500" mt-2 text-sm v-if="errors['name']"> {{ errors['name'] [0] }} </div>
            </div>
             <div>
                <label for="password">password</label>
                <input type="password" v-model="form.password" name="password" id="password">
                 <div class="text-red 500" mt-2 text-sm v-if="errors['password']"> {{ errors['password'] [0] }} </div>
            </div>
             <div>
                <label for="password_confirmation">confirm password</label>
                <input type="password" v-model="form.password_confirmation" name="password" id="password">
            </div>
            <button>Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
import router from '@/router'
import store from '@/store'
import { reactive, ref } from '@vue/reactivity'
export default {
    setup () {
        const errors = ref([])
        const form = reactive ({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        })

        const register = async () => {
            try {
                await axios.post('register', form)
                //perubahan realtime user
                await store.dispatch('auth/me')
                router.replace('/')
            } catch (e) {
                 errors.value = e.response.data.errors;
            }
        }

        return {form, register, errors}
    }
};
</script>

<style>

</style>