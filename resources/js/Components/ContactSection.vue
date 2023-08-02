<script setup>
import {ref, onMounted} from "vue";
import Swal from 'sweetalert2';
import {useForm} from "@inertiajs/vue3";
import {router} from "@inertiajs/vue3";

defineProps({
  configs: Object,
});

const form = useForm({
  persona: null,
  correo: null,
  asunto: null,
  mensaje: null,
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
  onSuccess: page => {
    Toast.fire({
      icon: 'success',
      title: page.props.flash.message,
    }).then(()=>{
      router.get('/')
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

function submit() {
  form.post('/mensajes/registrar', options)
}

</script>

<template>
  <!-- Contact Start -->
  <div class="container-xxl py-5 bg-light" id="contact">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <h1 class="mb-3">Contactos</h1>
          <p class="mb-4">Ante cualquier duda, contáctenos, por las vías disponibles o envíenos un mensaje a través del formulario.</p>
          <div class="d-flex mb-4">
            <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
              <i class="fa fa-phone-alt"></i>
            </div>
            <div class="ms-3">
              <p class="mb-2">Teléfono</p>
              <h5 class="mb-0">{{configs[2].config.telefonos}}</h5>
            </div>
          </div>
          <div class="d-flex mb-4">
            <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
              <i class="fa fa-envelope"></i>
            </div>
            <div class="ms-3">
              <p class="mb-2">Correo</p>
              <h5 class="mb-0">{{ configs[2].config.correos }}</h5>
            </div>
          </div>
          <div class="d-flex mb-0">
            <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
              <i class="fa fa-map-marker-alt"></i>
            </div>
            <div class="ms-3">
              <p class="mb-2">Dirección</p>
              <h5 class="mb-0">{{ configs[2].config.direccion }}</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <form @submit.prevent="submit">
            <div class="row justify-content-center align-items-center g-3">
              <h2 class="text-center"><i class="bi bi-messenger"></i> Enviar Mensaje</h2>
              <div class="col-md-6">
                <div class="form-floating">
                  <input v-model="form.persona" type="text" class="form-control" id="name" placeholder="Your Name">
                  <label for="name"><i class="bi bi-person"></i> Nombre y Apellidos</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input v-model="form.correo" type="email" class="form-control" id="email" placeholder="Your Email">
                  <label for="email"><i class="bi bi-at"></i> Correo Electrónico</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <input v-model="form.asunto" type="text" class="form-control" id="subject" placeholder="Subject">
                  <label for="subject"><i class="bi bi-question-circle"></i> Asunto</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <textarea v-model="form.mensaje" class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                  <label for="message"><i class="bi bi-messenger"></i> Mensaje</label>
                </div>
              </div>
              <div class="col-12">
                <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit"><i class="bi bi-send-check"></i> Enviar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Contact End -->
</template>
