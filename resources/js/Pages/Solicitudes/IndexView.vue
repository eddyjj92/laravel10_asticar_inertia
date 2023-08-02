<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import NProgress from 'nprogress';

const page = usePage()
const user = computed(() => page.props.auth.user)
let archivo = ref(null);

defineProps({
  solicitudes: Object,
});

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
if(page.props.permissions.includes('crear-solicitud')){
  hidden.value = '';
}

let dtConfig = {
  order: [[0, 'desc']],
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
      text:      '<i class="bi-plus-circle-dotted"> Nueva Solicitud</i>',
      action: function ( e, dt, node, config ) {
        router.get('/solicitudes/registrar');
      },
      className: `${hidden.value} text-white bg-success rounded fw-bold border-black border-2 border`,
    },
  ],
}

onMounted(()=>{
  $('#solicitudTable').DataTable(dtConfig);
})

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: pages => {
    Toast.fire({
      icon: 'success',
      title: pages.props.flash.message,
    }).then(()=>{
      router.get('/solicitudes');
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const deleteSolicitud = (id) =>{
  Swal.fire({
    title: 'Eliminar Solicitud',
    text: "¿Está seguro q desea eliminar esta solicitud?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/solicitudes/eliminar/${id}`, options)
    }
  })
}

const form = useForm({
  id_solicitud: null,
  entidad: null,
  correo: null,
  telefono: null,
  solicitado_por: null,
  cargo: null,
  servicio: null,
  objeto_obra: null,
  trabajos_realizar: null,
  adicional: null,
  estado_solicitud: null,
  recibido_por: page.props.auth.user.name,
  cargo_recibe: page.props.auth.user.ocupacion
})

const showModal = (id) =>{
  NProgress.configure({ showSpinner: true });
  NProgress.inc();
  axios.get(`/solicitudes/ver/${id}`)
    .then(response => {
      form.id_solicitud = response.data.id
      form.entidad = response.data.entidad
      form.correo = response.data.correo
      form.telefono = response.data.telefono
      form.solicitado_por = response.data.solicitado_por
      form.cargo = response.data.cargo
      form.servicio = response.data.servicio.nombre
      form.objeto_obra = response.data.objeto_obra
      form.trabajos_realizar = response.data.trabajos_realizar
      form.adicional = response.data.adicional
      var myModalEl = document.querySelector('#solModal')
      var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
      modal.show();
      NProgress.done()
    });
}

const options2 = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: pages => {
    Toast.fire({
      icon: 'success',
      title: pages.props.flash.message,
    }).then(()=>{
      router.get('/solicitudes');
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const aprobarDenegar = (estado) => {
  var myModalEl = document.querySelector('#solModal')
  var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
  modal.hide();
  form.estado_solicitud = estado;
  form.post(`/solicitudes/actualizar/${form.id_solicitud}`, options2)
}
</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-grid"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-server"></i> Solicitudes de Servicio</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="solicitudTable">
        <thead>
        <tr>
          <th hidden>ID</th>
          <th>Servicio</th>
          <th>Entidad</th>
          <th>Persona Autorizada</th>
          <th>Estado Solicitud</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="sol in solicitudes" :key="sol.id">
          <td hidden>{{sol.id}}</td>
          <td>{{sol.servicio.nombre}}</td>
          <td style="width: 20%">
            <div class="col-lg-9 col-md-8">
              <div class="text-base fw-bold fst-italic"><span class="text-blue p-1 text-center"><i class="bi bi-buildings-fill"></i> {{ sol.entidad }}</span></div>
              <div class="font-normal"><span class="fw-bold"><i class="fa fa-phone-alt"></i> Teléfono:</span> {{ sol.telefono }}</div>
              <div class="font-normal"></div>
            </div>
          </td>
          <td style="width: 25%">
            <div class="row justify-content-center align-items-center w-100">
              <div class="col-12">
                <div class="text-base fw-bold fst-italic"><i class="bi bi-person"></i> {{ sol.solicitado_por }}</div>
                <div class="font-normal"><span class="fw-bold"><i class="bi bi-at"></i> Correo:</span>  {{ sol.correo }}</div>
                <div class="font-normal"><span class="fw-bold"><i class="bi bi-diagram-2"></i> Cargo:</span> {{ sol.cargo_solicita }}</div>
              </div>
            </div>
          </td>
          <td>
            <span v-if="sol.estado_solicitud === 'aprobada'" class="badge bg-success"><i class="bi bi-check-circle-fill"></i> {{sol.estado_solicitud}}</span>
            <span v-if="sol.estado_solicitud === 'denegada'" class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> {{sol.estado_solicitud}}</span>
            <span v-if="sol.estado_solicitud === 'pendiente'" class="badge bg-warning"><i class="bi bi-info-circle-fill"></i> {{sol.estado_solicitud}}</span>
          </td>
          <td width="100px">{{ sol.created_at }}</td>
          <td width="180px">
            <button v-if="$page.props.permissions.includes('editar-solicitud')" @click="showModal(sol.id)" :id="sol.id" class="btn btn-info m-1 rounded-3"><i :id="sol.id" class="bi bi-pencil-square fs-6"></i></button>
            <a v-if="sol.estado_solicitud === 'aprobada'" :href="`/solicitudes/imprimir/${sol.id}`" target="_blank" class="btn btn-success m-1 rounded-3"> <i class="bi bi-printer-fill text-white fs-6"></i></a><a v-else :href="`/solicitudes/imprimir/${sol.id}`" target="_blank" class="btn btn-success disabled m-1 rounded-3"> <i class="bi bi-printer-fill text-white fs-6"></i></a>
            <button v-if="$page.props.permissions.includes('eliminar-solicitud')" @click="deleteSolicitud(sol.id)" class="btn btn-danger m-1 rounded-3"> <i class="bi bi-trash fs-6"></i></button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Modal -->
  <div class="modal fade" id="solModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-pencil-square"></i> Revisión de Solicitud</h5>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i> </button>
        </div>
        <div class="modal-body">
          <div class="row align-items-center justify-content-center g-3">
            <div class="col-lg-2">
              <div class="form-floating">
                <input v-model="form.id_solicitud" type="text" class="form-control" id="idSolicitud" placeholder="Solicitud">
                <label for="idSolicitud"><i class="bi bi-123"></i> Solicitud</label>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-floating">
                <input v-model="form.servicio" type="text" class="form-control" id="nombreServicio" placeholder="Servicio">
                <label for="nombreServicio"><i class="fa fa-server"></i> Servicio</label>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-floating">
                <input v-model="form.entidad" type="text" class="form-control" id="entidadSol" placeholder="Entidad">
                <label for="entidadSol"><i class="fa fa-building"></i> Entidad</label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <input v-model="form.solicitado_por" type="text" class="form-control" id="personaSol" placeholder="Solicitado Por">
                <label for="personaSol"><i class="fa fa-user"></i> Solicitado Por</label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <input v-model="form.correo" type="text" class="form-control" id="correoSol" placeholder="Correo">
                <label for="correoSol"><i class="fa fa-mail-bulk"></i> Correo</label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <input v-model="form.telefono" type="text" class="form-control" id="phoneSol" placeholder="Teléfono">
                <label for="phoneSol"><i class="fa fa-phone"></i> Teléfono</label>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-floating">
                <input v-model="form.objeto_obra" type="text" class="form-control" id="objeto_obra" placeholder="Buque / Objeto de Obra">
                <label for="objeto_obra"><i class="fa fa-ship"></i> Buque / Objeto de Obra</label>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="form-floating">
                <textarea v-model="form.trabajos_realizar" style="min-height:150px" class="form-control" id="observacionesSol" cols="30" rows="10" placeholder="Trabajos a realizar"></textarea>
                <label for="observacionesSol"><i class="bi bi-text-wrap"></i> Trabajos a realizar</label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <textarea v-model="form.adicional" style="min-height:150px" class="form-control" id="Adicional" cols="30" rows="10" placeholder="Adicional"></textarea>
                <label for="Adicional"><i class="bi bi-text-wrap"></i> Adicional</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-arrow-left-right"></i> Cerrar</button>
          <button @click="aprobarDenegar('denegada')" type="button" id="btnDenegar" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i> Denegar</button>
          <button @click="aprobarDenegar('aprobada')" type="button" id="btnAprobar" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Aprobar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "/public/css/dashboard.css";
</style>
