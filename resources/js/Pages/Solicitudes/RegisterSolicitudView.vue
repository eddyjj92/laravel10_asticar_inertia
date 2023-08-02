<script setup>
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import Layout from '../../Layouts/Layout.vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  errors: Object,
  servicios: Object
});


const form = useForm({
  entidad: page.props.auth.user.entidad,
  correo: page.props.auth.user.email,
  telefono: page.props.auth.user.telefono,
  solicitado_por: page.props.auth.user.name,
  cargo: page.props.auth.user.ocupacion,
  servicio: null,
  objeto_obra: null,
  trabajos_realizar: null,
  adicional: null,
})

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1200,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    });
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: page => {
    Toast.fire({
      icon: 'success',
      title: page.props.flash.message,
    });
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

function submit() {
  form.post('/solicitudes/registrar', options)
}
</script>
<template>
  <div class="container-xxl bg-primary p-0">
    <Layout/>
    <div class="container-xxl py-6">
      <div class="container mt-1">
        <div class="row align-items-center justify-content-center py-4 g-5 my-8 mx-1">
          <div class="col-lg-8 wow fadeInUp my-8 border border-4 p-4 rounded rounded-5 bg-white " data-wow-delay="0.5s">
            <form @submit.prevent="submit" class="p-2">
              <div class="row align-items-center justify-content-center g-3">
                <h2 class="text-center mb-1" style="color: black"><i class="fa fa-server"></i> Formulario de Servicios</h2>
                <p class="mb-2 font-light" style="text-align: justify">Rellene los datos solicitados, escoja el servicio de su preferencia y envie el formulario. Su solicitud será revisada por el departamento comercial y nos comunicaremos con usted. Gracias por utilizar nuestros servicios.</p>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.entidad" type="text" class="form-control" id="entidad" placeholder="Entidad" readonly>
                    <label for="entidad"><i class="bi bi-building"></i> Entidad</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.correo" type="text" class="form-control" id="email" placeholder="Correo" readonly>
                    <label for="email"><i class="bi bi-at"></i> Correo</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.telefono" type="text" class="form-control" id="phone" placeholder="Teléfono" readonly>
                    <label for="phone"><i class="bi bi-phone"></i> Teléfono</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.solicitado_por" type="text" class="form-control" id="nombre" placeholder="Nombre" readonly>
                    <label for="nombre"><i class="bi bi-person-badge"></i> Nombre</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.cargo" type="text" class="form-control" id="cargo" placeholder="Cargo" readonly>
                    <label for="cargo"><i class="bi bi-person-rolodex"></i> Cargo</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <select v-model="form.servicio" type="text" class="form-select" id="servicio">
                      <option :value="null" selected>Seleccione Servicio</option>
                      <option v-for="service in servicios" :value="service.id">{{ service.nombre }}</option>
                    </select>
                    <label for="servicio"><i class="fa fa-server"></i> Servicios</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <input v-model="form.objeto_obra" type="text" class="form-control" id="objeto_obra" placeholder="Buque / Objeto de Obra">
                    <label for="objeto_obra"><i class="fa fa-ship"></i> Buque / Objeto de Obra</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <textarea v-model="form.trabajos_realizar" type="text" class="form-control" style="min-height: 150px" id="observaciones" placeholder="Observaciones"></textarea>
                    <label for="cargo"><i class="bi bi-hammer"></i> Trabajos a realizar</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <textarea v-model="form.adicional" type="text" class="form-control" style="min-height: 150px" id="observaciones" placeholder="Observaciones"></textarea>
                    <label for="cargo"><i class="bi bi-plus-square"></i> Datos Adicionales</label>
                  </div>
                </div>
                <div class="col-12">
                  <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-send-check"></i> Enviar Solicitud</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Footer/>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>
</template>

<style scoped>


</style>
