<template>
    <div class="container mx-auto">
        <div class="w-100">


           <div>
                add transaction history
                <form @submit.prevent="add"> 
                    <div>
                        <label for="name">name</label>
                        <input type="text" v-model="form.name" name="name" id="name">
                        <!-- <div class="text-red 500" mt-2 text-sm v-if="errors['name']"> {{ errors['name'] [0] }} </div>   -->
                    </div> 
                    <div>
                        <label for="amount">amount</label>
                        <input type="text" v-model="form.amount" amount="amount" id="amount">
                        <!-- <div class="text-red 500" mt-2 text-sm v-if="errors['amount']"> {{ errors['amount'] [0] }} </div>   -->
                    </div> 
                    <div>
                        <label for="when">when</label>
                        <input type="date" v-model="form.when" when="when" id="when">
                        <!-- <div class="text-red 500" mt-2 text-sm v-if="errors['when']"> {{ errors['when'] [0] }} </div>   -->
                    </div> 
                    <div>
                        <label for="description">description</label>
                        <textarea v-model="form.description" description="description" id="description"></textarea>
                        <!-- <div class="text-red 500" mt-2 text-sm v-if="errors['description']"> {{ errors['description'] [0] }} </div>   -->
                    </div>
                     <button>add transaction</button>
                </form>
            </div>
          



            <div>
                filter
            </div>


            <form @submit.prevent="getCashes" class="d-flex">
                <input type="date" v-model="form.begin">
                <input type="date"  v-model="form.to"> 
                <input type="submit" value="go">
            </form>


 
            <div>
                balance = RP {{ state.balances }}
            </div>

            <div>
                debit = RP {{ state.debit }}
            </div>

            <div>
                kredit =  RP {{ state.credit }}
            </div>

            <div>
                transaksi
            </div>

            
            <div class="px-5 py-4">
                <tr v-for="transaction in state.transaction" :key="transaction.id">
                <router-link :to="`/cashes/${transaction.slug}`">
                     <span>beli hp = {{ transaction.name }}</span>
                    <span>tanggal = {{ transaction.when }}</span>
                    <span :class="transaction.isCredit ? 'text-danger' : 'text-primary'">harga = {{ transaction.amount }}</span>
                </router-link>
                </tr>
              
            </div>

        </div>
    </div>
</template>

<script>
import { ref, onMounted, reactive } from 'vue'
import axios from 'axios'
export default {
    setup () {
        const state = ref([])

        const form = reactive({
            begin:'',
            to: '',
            
                    name: '',
                    amount: '',
                    when: '',
                    description: '',
        })

        const getCashes = async () => {
            let {data} = await axios.get('api/cash', {
                params: {
                    from: form.begin,
                    to: form.to,
                }
            });

            state.value = data
            form.begin = data.firstOfMonth
            form.to = data.now
        }

        const add = async () => {
            let response = await axios.post('api/cash/create', form)
            state.value.transaction.unshift(response.data.cash)
        }

        onMounted(() => {
            getCashes()
        })

        return { state, form, getCashes, add }
    }
}
</script>

<style>

</style>