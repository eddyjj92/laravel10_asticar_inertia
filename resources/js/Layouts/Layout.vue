<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import Swal from "sweetalert2";
import {computed} from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user)

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

if(page.props.flash.message){
  Toast.fire({
    icon: 'success',
    title: page.props.flash.message
  });
  const audio = new Audio("/audio/Notification-bonus-points.mp3");
  audio.play();
}

if(page.props.errors.validacion){
  Toast.fire({
    icon: 'error',
    title: page.props.errors.validacion
  });
  const audio = new Audio("/audio/click-error.wav");
  audio.play();
}

</script>

<template>
  <!-- Navbar & Hero Start -->
  <div class="container-xxl position-relative p-0" id="home">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
      <Link href="/" class="navbar-brand p-0">
        <img src="/img/asticar.png" alt="Logo">
      </Link>
      <button class="navbar-toggler rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto py-0">
          <Link href="/" class="nav-item nav-link"><i class="bi bi-house"></i> Inicio</Link>
          <Link href="/solicitudes/registrar" class="nav-item nav-link"><i class="fa fa-server"></i> Servicios</Link>
          <a href="#about" class="nav-item nav-link"><i class="bi bi-info-circle-fill"></i> Acerca</a>
          <a href="#blog" class="nav-item nav-link"><i class="bi bi-newspaper"></i> Blog</a>
          <a href="#contact" class="nav-item nav-link"><i class="bi bi-phone-fill"></i> Contactos</a>

        </div>
        <Link v-if="user" href="/login" class="btn btn-light rounded-pill py-2 px-4 ms-3 d-lg-block"><i class="bi bi-key"></i> {{user.email}}</Link>
        <Link v-else href="/login" class="btn btn-light rounded-pill py-2 px-4 ms-3 d-lg-block"><i class="bi bi-key"></i> Iniciar Sesión</Link>
      </div>
    </nav>
  </div>


</template>
