<template>
    <div class="border-bottom py-3">
        <div class="d-flex justify-content-between">
            <div class="px-3">
                <router-link class="fw-bold fs-2" to="/">
                    Cashinout
                </router-link>

                <button @click="isOn = !isOn" class="d-block d-lg-none">   
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
            </div>

                
                    <div :class="isOn ? `block` : `hidden`" class="d-flex justify-content-between align-items-center w-100 px-3">
                            <div class="d-flex align-items-center">
                                <router-link to='/about'>About</router-link>
                                <router-link to='/cashes'>Cash</router-link>
                            </div>
                        
                            <div class="d-flex align-items-center" v-if="authenticated">
                                <router-link class="px-3" to='/login'>{{ user.name }}</router-link>
                                <button class="px-3" @click="logout">logout</button>
                            </div>
                        
                            <div class="d-flex align-items-center" v-else>
                                <router-link class="px-3" to='/login'>Login</router-link>
                                <router-link class="px-3" to='/register'>Register</router-link>
                            </div>
                    </div>
        </div>
    </div>
</template>

<script>
import { computed, ref } from "vue";
import store from '@/store'
export default {
    setup() {
        const isOn = ref(3)
        const authenticated = computed(() => store.getters['auth/authenticated'])
        const user = computed(() => store.getters['auth/user'])

        const logout = async () => {
            store.dispatch("auth/logout")
        }


        return { isOn, authenticated, user, logout }  

    },

}
</script>

<style>

</style>