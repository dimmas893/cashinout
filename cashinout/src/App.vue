<template>
     <div>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
          <Navbar/>
          <div class="mt-4"></div>
          <router-view/>
     </div>
</template>

<script>
import Navbar from '@/components/Navbar'
export default {
     components: { Navbar },

}
</script>

<style>

</style>