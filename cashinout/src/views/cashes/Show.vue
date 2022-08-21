<template>
    <div class="container">
        <div>
            {{ transaction.name }}
            {{ transaction.amount }}
            {{ transaction.when }}
            {{ transaction.description }}
        </div>
    </div>
</template>

<script>
import {  onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import router from '@/router'
export default {
    setup () {
        const transaction = ref([])
        const route = useRoute()
       let slug = route.params.slug

       const getTransaction = async () => {
           try{
                let {data} = await axios.get(`api/cash/${slug}`)
                transaction.value = data.data
           }catch{
               router.replace('/cashes')
           }
       }

       onMounted(() => {
           getTransaction()
       })

       return {transaction}
    }
}
</script>

<style>

</style>