<script setup>
import {computed, onMounted, onUnmounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
let archivo = ref(null);

defineProps({
  users: Object,
});

const form = useForm({
  archivo: null,
})

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

let hidden = ref('visually-hidden');
if(page.props.permissions.includes('crear-usuario')){
  hidden.value = '';
}

let dtConfig = {
  "order": [[ 0, 'asc' ]],
  language: {
    url: `/datatables/es`
  },
  dom: 'lBfrtip',
  select: true,
  lengthMenu: [
    [10, 25, 50, 100, -1],
    ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
  ],
  buttons: [
    {
      text:      '<i class="bi-person-add"> Nuevo Usuario</i>',
      action: function ( e, dt, node, config ) {
        router.get('/usuario/registrar');
      },
      className: `${hidden.value} text-white bg-success rounded fw-bold border-black border-2 border`,
    },
    {
      text:      '<i class="fa fa-file-import"> Importar Usuarios</i>',
      action: function ( e, dt, node, config ) {
        var myModalEl = document.querySelector('#importModal')
        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
        modal.show();
      },
      className: `${hidden.value} text-white bg-blue rounded fw-bold border-black border-2 border`,
    },
  ],
}

onMounted(()=>{
  $('#usersTable').DataTable(dtConfig);
})

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: pagen => {
    page.props.users = pagen.props.users;
    Toast.fire({
      icon: 'success',
      title: 'Usuario Eliminado con Éxito'
    }).then(()=>{
      router.get(`/usuarios`);
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const deleteUser = (id) =>{
  Swal.fire({
    title: 'Eliminar Usuario',
    text: "¿Está seguro q desea eliminar este usuario?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/usuario/eliminar/${id}`, options)
    }
  })
}


const uploadFile = async (e) => {
  let selectedFile  = e.target.files[0];
  let data = [{}];
  XLSX.utils.json_to_sheet(data, 'out.xlsx');
  if(selectedFile && fileValidation()){
    let fileReader = new FileReader();
    fileReader.readAsBinaryString(selectedFile);
    fileReader.onload = (event)=>{
      let data = event.target.result;
      let workbook = XLSX.read(data,{type:"binary"});
      console.log(workbook);
      workbook.SheetNames.forEach(sheet => {
        let data = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
        form.archivo = data;
        let i = 0;
        const $archivo = document.querySelector("#archivo");
        data.forEach(dato =>{
          if(Object.values(dato).length !== 6 && i === 0){
            i++;
            Swal.fire({
              icon: 'error',
              title: 'Estructura no válida',
              text: 'El documento no tiene la estructura necesaria de 6 columnas'
            });
            $archivo.value = "";
          }else if(!dato.nombre){
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta un nombre de usuario en el documento'
            });
            $archivo.value = "";
          }else if (!dato.correo) {
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta una cuenta de correo en el documento'
            });
            $archivo.value = "";
          }else if (!dato.contrasena) {
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta una contraseña en el documento'
            });
            $archivo.value = "";
          }else if (!dato.telefono) {
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta un teléfono en el documento'
            });
            $archivo.value = "";
          }else if (!dato.entidad) {
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta una entidad en el documento'
            });
            $archivo.value = "";
          }else if (!dato.ocupacion) {
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: 'Falta una ocupacion en el documento'
            });
            $archivo.value = "";
          }else if (!validaEmail(dato.correo)){
            Swal.fire({
              icon: 'error',
              title: 'Validación de Datos',
              text: `La cuenta de correo ${dato.correo} no es válida`
            });
            $archivo.value = "";
          }

        })

      });
    }
  }
}

function fileValidation(){
  var fileInput = document.getElementById('archivo');
  var filePath = fileInput.value;
  var allowedExtensions = /(.xlsx)$/i;
  if(!allowedExtensions.exec(filePath)){
    Swal.fire({
      icon: 'error',
      title: 'Validación de Datos',
      text: 'Solo se permiten archivos con extensión .xlsx'
    });
    fileInput.value = '';
    return false;
  }else{
    return true;
  }
}

function validaEmail(email) {
  var reMedio = /^(([^<>()\[\]\.,;:\s@\”]+(\.[^<>()\[\]\.,;: \s@\”]+)*)|(\”.+\”))@(([^<>()[\]\.,;:\s@\”]+\.)+[^ <>()[\]\.,;:\s@\”]{2,})$/;
  return reMedio.test(email);
}


const options2 = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: pages => {
    Toast.fire({
      icon: 'success',
      title: pages.props.flash.message
    }).then(()=>{
      router.get(`/usuarios`);
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

function submit() {
  if(form.archivo){
    let myModalEl = document.querySelector('#importModal')
    let modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
    modal.hide();
    form.post('/usuarios/importar', options2)
  }else{
    Swal.fire({
      icon: 'warning',
      title: 'Validación de Datos',
      text: 'Seleccione un archivo'
    });
  }

}

</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person"></i> Usuarios</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="usersTable">
        <thead>
          <tr>
            <th hidden>Id</th>
            <th>Usuario</th>
            <th>Entidad</th>
            <th>Rol de Usuario</th>
            <th>Conectado</th>
            <th>Habilitado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="usr in users" :key="usr.id">
            <td hidden>{{ usr.id }}</td>
            <td style="width:28%">
              <div class="row justify-content-center align-items-center w-100">
                <div class="col-lg-4 col-md-5">
                  <img class="rounded rounded-3 w-100 h-100" :src="`img/profile/${usr.imagen}`">
                </div>
                <div class="col-lg-8 col-md-7">
                  <div class="text-base fw-bold">{{ usr.name }}</div>
                  <div class="font-normal">{{ usr.email }}</div>
                  <div class="font-normal">{{ usr.ocupacion }}</div>
                </div>
              </div>
            </td>
            <td style="width:20%">
              <div class="">
                <div class="text-base fw-bold">{{ usr.entidad }}</div>
                <div class="font-normal">Teléfono {{ usr.telefono }}</div>
              </div>
            </td>
            <td v-if="usr.roles"><span v-for="role in usr.roles"><Link :href="`/roles/editar/${role.id}`"><span class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Rol de Usuario ${usr.name}`" data-bs-delay='{"show":0,"hide":0}'>{{role.name}}</span></Link> </span></td>
            <td><span v-if="usr.conectado ==='conectado'" class="badge bg-success"><i class="bi bi-link"></i> {{ usr.conectado }}</span><span v-else-if="usr.conectado ==='desconectado'" class="badge bg-danger"><i class="bi bi-power"></i> {{ usr.conectado }}</span><span v-else-if="usr.conectado ==='sin autenticar'" class="badge bg-warning"><i class="bi bi-exclamation-circle-fill"></i> {{ usr.conectado }}</span></td>
            <td><input :disabled="!$page.props.permissions.includes('banear-usuario')" type="checkbox" @click="router.get(`/usuario/enable_disable/${usr.id}`)" v-model="usr.habilitado"></td>
            <td width="180px">
              <Link v-if="$page.props.permissions.includes('ver-usuario')" :href="`/usuario/perfil/${usr.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Perfil de Usuario ${usr.name}`" data-bs-delay='{"show":0,"hide":0}'><i class="bi bi-eye-fill"></i></Link>
              <Link v-if="$page.props.permissions.includes('editar-usuario')" :href="`/usuario/editar/${usr.id}`" class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Usuario ${usr.name}`"><i class="bi bi-pencil-square fs-6"></i></link>
              <button v-if="$page.props.permissions.includes('eliminar-usuario')" @click="deleteUser(usr.id)" class="btn btn-danger m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Usuario ${usr.name}`"> <i class="bi bi-trash fs-6"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Modal -->
  <div class="modal  fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-file-excel"></i> Importar Usuarios</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row align-items-center justify-content-center g-3">
            <div class="col-lg-12">
              <div>
                <form>
                  <input @change="uploadFile" class="form-control form-control-lg bg-white" id="archivo" type="file" accept=".xlsx">
                  <span class="small text-muted fst-italic"> El archivo a importar tiene q estar en formato excel (.xlsx), con todos los datos cargados en su estructura de 6 columnas, puede descargar el modelo para importar usuarios haciendo click <a class="fw-bold" target="_blank" :href="`/usuarios.xlsx`"><span class="badge bg-success fs-6"><i class="fa fa-download"></i> aquí.</span> </a></span>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
          <button @click="submit" type="button" id="btnImportar" class="btn btn-primary"><i class="fa fa-file-import"></i> Importar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "/public/css/dashboard.css";
</style>
