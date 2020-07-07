<template>
    <div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="searchHelp">Buscar</span>
            </div>
            <input type="text" class="form-control" placeholder="Escriba aquí" aria-label="search" aria-describedby="searchHelp" v-model="search" @keyup.enter="searchMembers">
        </div>
        <small class="form-text text-muted mb-4">Puedes buscar por una parte del nombre, del email o incluso del número telefónico!</small>
        <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <li v-for="member in results" class="col-span-1 bg-white rounded-lg shadow">
                <div class="w-full flex items-center justify-between p-6 space-x-6">
                    <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-gray-900 text-sm leading-5 font-medium truncate">{{ member.first_name }} {{ member.last_name }}</h3>
                        </div>
                        <p class="mt-1 text-gray-500 text-sm leading-5 truncate">
                            <span class="inline-flex">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg> 
                                &nbsp;{{ member.phone}}
                            </span>
                            <br>
                            <span class="inline-flex">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg> 
                                &nbsp;{{ member.email }}
                            </span>
                        </p>
                    </div>
                    <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" :src="member.image" />
                </div>
                <div class="border-t border-gray-200">
                    <div class="-mt-px flex">
                        <div class="-ml-px w-0 flex-1 flex">
                            <a :href="add_url+member.id" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                                Agregar a la clase
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="bg-white shadow sm:rounded-lg mt-6" v-if="searched">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Crear un nuevo registro
                        </h3>
                        <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                            <p>
                                ¿No encuentras lo que buscas? Si estás segur@ que has buscado bien, puedes crear un nuevo registro en la base de datos.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                        <span class="inline-flex rounded-md shadow-sm">
                          <button v-if="!create" @click="create=true" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                            Crear registro
                          </button>
                        </span>
                    </div>
                </div>
                <div class="row mt-6" v-if="create">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Nombres</label>
                            <input type="text" :class="{ 'is-invalid' : errors.first_name }" class="form-control" id="first_name" aria-describedby="first_nameHelp" placeholder="Nombre" v-model="user.first_name" @keyup="resetErrors('first_name')">
                            <small v-if="errors.first_name" id="first_nameHelp" class="form-text invalid-feedback">{{ errors.first_name[0] }}</small>
                            <small v-else id="first_nameHelp" class="form-text text-muted">Escriba lo(s) nombre(s)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Apellidos</label>
                            <input type="text" :class="{ 'is-invalid' : errors.last_name }" class="form-control" id="last_name" aria-describedby="last_nameHelp" placeholder="Apellidos" v-model="user.last_name" @keyup="resetErrors('last_name')">
                            <small v-if="errors.last_name" id="last_nameHelp" class="form-text invalid-feedback">{{ errors.last_name[0] }}</small>
                            <small v-else id="last_nameHelp" class="form-text text-muted">Escriba lo(s) apellido(s)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" :class="{ 'is-invalid' : errors.email }" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" v-model="user.email" @keyup="resetErrors('email')">
                            <small v-if="errors.email" id="emailHelp" class="form-text invalid-feedback">{{ errors.email[0] }}</small>
                            <small v-else id="emailHelp" class="form-text text-muted">Escriba la dirección de correo electrónico</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" :class="{ 'is-invalid' : errors.phone }" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="Teléfono" v-model="user.phone" @keyup="resetErrors('phone')">
                            <small v-if="errors.phone" id="phoneHelp" class="form-text invalid-feedback">{{ errors.phone[0] }}</small>
                            <small v-else id="phoneHelp" class="form-text text-muted">Escriba el número celular o fijo</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-success" @click="createMember">Crear registro</button>
                    </div>
                </div>
            </div>
        </div>
        <spinner v-if="loading"></spinner>
    </div>
</template>

<script>
  export default {
    props: ['add_url'],
    data () {
      return {
        loading: 0,
        search: '',
        results: [],
        searched: false,
        user: {
          first_name: '',
          last_name: '',
          phone: '',
          email: '',
        },
        create: false,
        errors: {},
      }
    },
    methods: {
      resetErrors (field) {
        Vue.delete(this.errors, field);
      },
      searchMembers () {
        if (this.search) {
          this.loading++
          axios.post('/members/search', {search: this.search}).then(
            ({data}) => {
              if (data.members) this.results = data.members
              this.loading--
              this.searched = true
            }
          ).catch(function (error) {
            this.loading--
          }.bind(this))
        }
      },
      createMember () {
        this.loading++
        axios.post('/members', {
          first_name: this.user.first_name,
          last_name: this.user.last_name,
          email: this.user.email,
          phone: this.user.phone,
        }).then(
          ({data}) => {
            if (data.member) document.location.href = this.add_url + data.member.id
            this.loading--
          }
        ).catch(
          (error) => {
            this.loading--
            if (error.response) {
              if (error.response.status === 422) {
                var data = error.response.data;
                this.errors = data.errors;
              } else {
                console.log(error.response.status);
              }
            } else {
              console.log('Error', error.message);
            }
          }
        );
      },
    }
  }
</script>
