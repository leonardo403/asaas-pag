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
            <input class="form-control" type="text" id="cpf_cnpj" v-model="client.cpf_cnpj" required />
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Endereço:</label>
            <input class="form-control" type="text" id="address" v-model="client.address" required />
          </div>
          <div class="mb-3">
            <label for="address_number" class="form-label">N°:</label>
            <input class="form-control" type="text" id="address_number" v-model="client.address_number" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input class="form-control" type="text" id="email" v-model="client.email" required />
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Telefone:</label>
            <input class="form-control" type="text" id="phone" v-model="client.phone" required />
          </div>
          <div class="mb-3">
            <label for="postal_code" class="form-label">CEP:</label>
            <input class="form-control" type="text" id="postal_code" v-model="client.postal_code" required />
          </div>
          <div class="mb-3">
            <label for="province" class="form-label">Bairro:</label>
            <input class="form-control" type="text" id="province" v-model="client.province" required />
          </div>
          <button type="submit" v-if="isNewClient" class="btn btn-primary">Salvar </button>
          <button type="submit" v-else class="btn btn-primary">Atualizar Cliente</button>
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
          address: '',
          address_number: '',
          email: '',
          phone: '',
          postal_code: '',
          province: ''
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
        this.client = response.data;
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
