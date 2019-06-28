<template>
    <div>
            <input @keyup="buscar" style="margin-left: 50px;" type="text" v-model="filter"
                   class="form-control mr-sm-2"
                   placeholder="Pesquisar:">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filter: ''
            }
        },

        methods: {
            buscar() {
                this.$emit('findContato', this.filter)
                // $emit envia a ação para o componente pai, ou seja, aonde esta sendo utilizado o component que disparou o metodo
            }
        }
    }
</script>

<style scoped>

</style>
