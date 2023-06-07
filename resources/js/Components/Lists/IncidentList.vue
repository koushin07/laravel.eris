<template>
      <v-select :options="convertedIncident" v-model="filter" class="w-full h-8 rounded cursor-pointer"
                    placeholder="Incident" />
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';


const incidents = ref();

axios.get('/api/incidents').then((res)=>incidents.value = res.data)

</script>

<style lang="scss" scoped>
 

</style>