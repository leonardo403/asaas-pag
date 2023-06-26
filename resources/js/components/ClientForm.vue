<template>
    <div>
      <h2 v-if="isNewClient">Cadastrar cliente</h2>
      <h2 v-else>Editar Cliente</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input class="form-control" type="text" id="name" v-model="client.name" required />
          </div>
          <div class="mb-3">
            <label for="cpf_cnpj" class="form-label">CPF_CNPJ:</label>
            <input class="form-control" type="number" id="cpf_cnpj" v-model="client.cpf_cnpj" required />
          </div>
          <button type="submit" v-if="isNewClient" class="btn btn-primary">Salvar </button>
          <button type="submit" v-else class="btn btn-primary">Update Product</button>
        </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        client: {
          name: '',
          cpf_cnpj: '',

        }
      }
    },
    computed: {
      isNewClient() {
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewClient) {
        const response = await axios.get(`/api/clients/${this.$route.params.id}`);
        this.product = response.data;
      }
    },
    methods: {
      async submitForm() {
        try {
          if (this.isNewClient) {
            await axios.post('/api/clients', this.client);
          } else {
            await axios.put(`/api/clients/${this.$route.params.id}`, this.client);
          }
          this.$router.push('/');
        } catch (error) {
          console.error(error);
        }
      }
    }
  }
  </script>
