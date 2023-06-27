<template>
    <div>
        <h5 id="associating-form-text-with-form-controls">Name:</h5>
        <h6>{{ client.name }}</h6>
        <h5 id="associating-form-text-with-form-controls">CPF_CNPJ:</h5>
        <p>{{ client.cpf_cnpj }}</p>
        <h5 id="associating-form-text-with-form-controls">Telefone:</h5>
        <p>Telefone: {{ client.phone }}</p>
        <router-link :to="`/payments/${payment.id}/edit`" class="btn btn-primary">Editar</router-link>
    </div>
</template>

<script>
import axios from 'axios';

export default {
data() {
    return {
    payment: {}
    }
},
async created() {
    try {
    const response = await axios.get(`/api/payments/${this.$route.params.id}`);
    this.client = response.data;
    } catch (error) {
    console.error(error);
    }
}
}
</script>
