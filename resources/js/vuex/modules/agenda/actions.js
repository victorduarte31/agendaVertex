import axios from 'axios'

export default {
    loadContatos(context, params) {
        axios.get('', {params})
            .then(response => {
                console.log(response);
                context.commit('LISTA_CONTATO', response.data)
            })
            .catch(error => console.log(error))
    }

}
