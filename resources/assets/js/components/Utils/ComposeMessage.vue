<template>
    <div>
        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:border-indigo-600 focus:shadow-outline-indigo active:bg-indigo-600 transition ease-in-out duration-150" data-toggle="modal" data-target="#composeMessageModal">
            <svg class="-ml-0.5 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
            {{ this.label }}
        </button>
        <div class="modal fade" id="composeMessageModal" tabindex="-1" role="dialog" aria-labelledby="composeMessageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Redactar un nuevo mensaje</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <input type="text" v-model="subject" id="subject" name="subject" placeholder="Escribe un asunto" :class="{ 'is-invalid' : errors.subject }" class="form-control" @keyup="resetErrors('subject')">
                            <small v-if="errors.subject" id="subjectHelp" class="form-text invalid-feedback">{{ errors.subject[0] }}</small>
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea v-model="message" id="message" name="message" placeholder="Escriba aqui su mensaje" :class="{ 'is-invalid' : errors.message }" class="form-control" rows="5" @keyup="resetErrors('message')"></textarea>
                            <small v-if="errors.message" id="messageHelp" class="form-text invalid-feedback">{{ errors.message[0] }}</small>
                        </div>
                        <spinner v-if="loading"></spinner>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="sendMessage">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import PNotify from '../../../../../node_modules/@pnotify/core/dist/PNotify.js';
  // PNotify.defaults.styling = "bootstrap4"; 
  
  export default {
    props: {
      emails: {
        type: Array,
        default: []
      },
      label: {
        type: String,
        default: 'Escribir Mensaje'
      },
    },
    data () {
      return {
        subject: '',
        message: '',
        loading: 0,
        errors:{}
      }
    },
    mounted () {
      window.$('#composeMessageModal').on('shown.bs.modal', function () {
        window.$('#subject').trigger('focus')
      })
    },
    methods: {
      resetErrors (field) {
        Vue.delete(this.errors, field);
      },
      sendMessage () {
        this.loading++
        axios.post('/messages', {
          subject: this.subject,
          message: this.message,
          emails: this.emails 
        }).then(
          ({data})=>{
            this.loading--
            this.subject = ''
            this.message = ''
            window.$('#composeMessageModal').modal('hide')
            if(data.message)PNotify.success(data.message)
          }
        ).catch(
          ({response})=>{
            PNotify.error("No se ha podido enviar el mensaje, corrige los errores e intenta nuevamente");
            if(response.data.errors)this.errors = response.data.errors
            this.loading--
          }
        )
      }
    },
  }
</script>

