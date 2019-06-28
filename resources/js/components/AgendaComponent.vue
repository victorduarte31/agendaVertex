<template>
    <div class="container">
        <h2 align="center">Agenda de contatos</h2>
        <hr>

        <form @submit.prevent="cadastraContato" class="form" v-if="mostraFormulario">
            <h3 align="center">Cadastro de Contatos</h3>

            <div :class="['form-group', {'alert alert-warning': errors.nome}]">
                <div v-if="errors.nome">{{errors.nome[0]}}</div>
                <label class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                    <input v-model="nome" type="text" class="form-control" placeholder="nome">
                </div>
            </div>
            <div :class="['form-group', {'alert alert-warning': errors.telefone}]">
                <div v-if="errors.telefone">{{errors.telefone[0]}}</div>
                <label class="col-sm-2 col-form-label">Telefone</label>
                <div class="col-sm-10">
                    <the-mask placeholder="telefone" v-model="telefone" class="form-control"
                              :mask="['(##) #####-####']"/>
                </div>
            </div>

            <div :class="['form-group', {'alert alert-warning': errors.email}]">
                <div v-if="errors.email">{{errors.email[0]}}</div>
                <label class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input v-model="email" type="email" class="form-control" placeholder="E-mail">
                </div>
            </div>

            <form @submit.prevent="buscaCep">
                <div class="form-group">
                    <label class="col-sm-2 col-form-label">CEP:</label>
                    <div class="col-sm-10">
                        <the-mask placeholder="CEP" v-model="cep" class="form-control" :mask="['########']"/>
                        <button class="btn btn-outline-success"
                                type="submit">Pesquisar
                        </button>
                    </div>
                </div>
            </form>
            <br><br>
            <button v-if="cadastrar" class="btn btn-success" type="submit">Cadastrar</button>

        </form>

        <div v-else>

            <div v-if="exibeContatos">

                <div class="form-inline">
                    <button class="btn btn-success" @click.prevent="showForm">Cadastrar</button>

                    <buscar @findContato="buscarContato"></buscar>
                </div>
                <br><br>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CEP</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="contato in cepApi" :key="contato.id">
                        <td>{{contato.nome}}</td>
                        <td>{{contato.telefone}}</td>
                        <td>{{contato.email}}</td>
                        <td>{{contato.cep}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <h2 align="center">Sem contatos cadastrados</h2>
                <a @click.prevent="showForm" href="#">Clique aqui para cadastrar</a>
            </div>

        </div>

    </div>
</template>

<script>
    import BuscaContato from "./BuscaContato";

    export default {
        data() {
            return {
                nome: '',
                telefone: '',
                email: '',
                cep: '',
                cepApi: {},
                mostraFormulario: false,
                exibeContatos: false,
                errors: {},
                find: '',
                cadastrar: false
            }
        },

        created() {
            this.listaContatos();
        },

        methods: {
            showForm() {
                this.mostraFormulario = true;
            },

            buscaCep() {
                this.$http.get('https://viacep.com.br/ws/' + this.cep + '/json/')
                    .then(response => {

                        if (response.body.erro === true) {
                            this.$snotify.error('CEP NÃO ENCONTRADO', 'Erro');
                            this.cep = '';
                            this.cadastrar = false
                        } else {
                            this.$snotify.success('CEP VALIDADO COM SUCESSO', 'Sucesso');
                            this.cadastrar = true
                        }

                    })
            },

            listaContatos() {
                /* this.$http.get('http://localhost:8000/api/agenda/', {find: this.filter})*/
                this.$http.get(`http://localhost:8000/api/agenda/?find=${this.find}`)
                    .then(response => {
                        if (response.body.length > 0) {
                            console.log(response);
                            this.exibeContatos = true;
                            this.mostraFormulario = false;
                            this.cepApi = response.body;
                            this.limparFormulario()
                        } else {
                            this.mostraFormulario = false;
                        }
                    })
            },

            cadastraContato() {

                const formData = new FormData();

                formData.append('nome', this.nome);
                formData.append('telefone', this.telefone);
                formData.append('email', this.email);
                formData.append('cep', this.cep);

                console.log(formData);

                this.$http.post('http://localhost:8000/api/agenda', formData)
                    .then(response => {

                        if (response.status === 201) {
                            this.$snotify.success('CONTATO SALVO COM SUCESSO', 'Sucesso');
                            this.listaContatos()
                        }
                    })
                    .catch(error => {
                        this.errors = error.body.errors;
                        this.limparFormulario()
                    })

            },

            buscarContato(filter) {
                this.find = filter;
                this.listaContatos();
            },

            limparFormulario() {
                this.nome = '';
                this.telefone = '';
                this.email = '';
                this.cep = '';
            }
        },
        components: {
            buscar: BuscaContato
        }
    }
</script>

<style scoped>

</style>
