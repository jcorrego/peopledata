<template>
    <div>
        <div class="">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <img v-if="course.professor" :src="course.professor.image" :alt="course.professor.name" class="rounded-circle img-fluid img-thumbnail mb-1" width="100">
                    </div>
                    <div class="col-md-4">
                        <h6 class="card-title" v-if="course.professor">
                            <strong>Profesor:</strong>
                            <a :href="'/members/'+ course.professor.id">{{ course.professor.first_name }} {{ course.professor.last_name }}</a><br>
                            <small class="text-muted">{{ course.professor.email }}</small>
                            <br>
                            <small class="text-muted">Tel: {{ course.professor.phone }}</small>
                        </h6>
                    </div>
                    <div class="col-md-7 text-right">
                            <span class="inline-flex rounded-md shadow-sm">
                              <a target="_blank" :href="'/courses/'+course.id+'/students-pdf'" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                <i class="far fa-file-pdf mr-2"></i>Formatos PDF
                              </a>
                            </span>
                            <span class="inline-flex rounded-md shadow-sm">
                              <a target="_blank" :href="'/courses/'+course.id+'/courselist'" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                <i class="far fa-file-pdf mr-2"></i>Lista de clase en PDF
                              </a>
                            </span>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row text-center">
                        <div class="col-md-4"><strong>Estudiante</strong></div>
<!--                        <div class="col-md-2"><strong>Estado</strong></div>-->
<!--                        <div class="col-md-2" v-if="course.value"><strong>Pago</strong></div>-->
                        <div class="col-md-3"><strong>Observaciones</strong></div>
                        <div class="col-md-1">&nbsp;</div>
                    </div>
                </li>
                <li v-for="member in activeMembers" :class="'list-group-item list-group-item-'+ calculateClass(member.pivot.status)">
                    <student-inscription :member="member" :course_id="course.id" @change="updateMember($event,member.id)" :value="course.value"></student-inscription>
                </li>
                <li class="list-group-item" v-if="activeMembers.length === 0">
                    No hay estudiantes inscritos
                </li>
            </ul>
            <div class="card-body">
                <a :href="'/courses/'+ course.id +'/search'" class="btn btn-success">Agregar estudiante</a>
                <a href="/courses" class="btn btn-secondary">Cancelar</a>
            </div>
            <ul class="list-group list-group-flush" v-if="inactiveMembers.length > 0">
                <li class="list-group-item">
                    <div class="row text-center">
                        <div class="col-md-12"><strong>Estudiantes que cancelaron o no empezaron el curso</strong></div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row text-center">
                        <div class="col-md-4"><strong>Estudiante</strong></div>
                        <div class="col-md-2"><strong>Estado</strong></div>
                        <div class="col-md-2"><strong>Pago</strong></div>
                        <div class="col-md-3"><strong>Observaciones</strong></div>
                        <div class="col-md-1">&nbsp;</div>
                    </div>
                </li>
                <li v-for="member in inactiveMembers" :class="'list-group-item list-group-item-'+ calculateClass(member.pivot.status)">
                    <student-inscription :member="member" :course_id="course.id" @change="updateMember($event,member.id)"></student-inscription>
                </li>
            </ul>
        </div>
        <spinner v-if="loading"></spinner>
    </div>
</template>

<script>
  export default {
    props: ['course'],
    data () {
      return {
        members: [],
        subject:'',
        message: '',
        loading: 0,
      }
    },
    mounted () {
      this.loading++
      axios.get('/courses/' + this.course.id + '/students').then(
        ({data}) => {
          if (data.members) this.members = data.members
          this.loading--
        }
      ).catch((error) => {
        console.log(error)
        this.loading--
      })
    },
    methods: {
      calculateClass (status) {
        if (status === 'completed') return 'success'
        else if (status === 'didnt_start') return 'danger'
        else if (status === 'didnt_finish') return 'warning'
        else return ''
      },
      updateMember(updates,memberid){
        this.members.forEach(function(element){
          if(element.id === memberid){
            element.pivot.status = updates.status
            element.pivot.payment = updates.payment
            element.pivot.notes = updates.notes
          }
        })
      },
    },
    computed:{
      activeMembers(){
        return this.members.filter(function(item){
          return item.pivot.status !== 'didnt_start' && item.pivot.status !== 'didnt_finish'
        })
      },
      activeEmails(){
        let emails = []
        this.members.forEach(function(item){
          if(item.pivot.status !== 'didnt_start' && item.pivot.status !== 'didnt_finish' && item.email){
            emails.push(item.email)
          }
        })
        return emails
      },
      inactiveMembers(){
        return this.members.filter(function(item){
          return item.pivot.status === 'didnt_start' || item.pivot.status === 'didnt_finish'
        })
      }
    }
  }
</script>

