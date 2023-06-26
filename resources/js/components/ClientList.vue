<template>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">CPF_CNPJ</th>
                <th scope="col">Telefone</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients" :key="client.asaas_id">
                    <td>{{ client.asaas_id }}</td>
                    <td>{{ client.name }}</td>
                    <td>{{ client.cpf_cnpj }}</td>
                    <td>{{ client.phone }}</td>
                    <td>
                      <div class="row gap-3">
                        <router-link :to="`/clients/${client.id}`" class="p-2 col border btn btn-primary">Ver</router-link>
                        <router-link :to="`/clients/${client.id}/edit`" class="p-2 col border btn btn-success">Editar</router-link>
                        <button @click="deleteClient(client.asaas_id)" type="button" class="p-2 col border btn btn-danger">Deletar</button>
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      clients: []
    }
  },
  async created() {
    try {
      const response = await axios.get('/api/clients');
      this.clients = response.data;
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    async deleteClient(id) {
      try {
        await axios.delete(`/api/clients/${id}`);
        this.clients = this.clients.filter(client => client.asaas_id !== asaas_id);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
