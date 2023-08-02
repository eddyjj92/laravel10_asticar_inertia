<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
const page = usePage()
defineProps({
  configs: Object,
});
</script>

<template>
  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-body footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-3 px-lg-5">
      <div class="row g-5">
        <div class="col-md-4 col-lg-4">
          <p class="section-title text-white h5 mb-4">Contactos<span></span></p>
          <p><i class="fa fa-map-marker-alt me-3"></i>{{ configs[2].config.direccion }}</p>
          <p><i class="fa fa-phone-alt me-3"></i>{{ configs[2].config.telefonos }}</p>
          <p><i class="fa fa-envelope me-3"></i>{{ configs[2].config.correos }}</p>
          <div class="d-flex pt-2">
            <a v-if="configs[2].config.redes.twitter" class="btn btn-outline-light btn-social" :href="configs[2].config.redes.twitter"><i class="fab fa-twitter"></i></a>
            <a v-if="configs[2].config.redes.facebook" class="btn btn-outline-light btn-social" :href="configs[2].config.redes.facebook"><i class="fab fa-facebook-f"></i></a>
            <a v-if="configs[2].config.redes.instagram" class="btn btn-outline-light btn-social" :href="configs[2].config.redes.instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <p class="section-title text-white h5 mb-4">Enlaces<span></span></p>
          <a class="btn btn-link" href="#">Inicio</a>
          <RouterLink to="/servicio/solicitud" class="btn btn-link" >Servicios</RouterLink>
          <a class="btn btn-link" href="#about">Acerca</a>
          <a class="btn btn-link" href="#blog">Blog</a>
          <a class="btn btn-link" href="#contact">Contactos</a>
        </div>
        <div class="col-md-4 col-lg-4">
          <p class="section-title text-white h5 mb-4">Suscríbete<span></span></p>
          <p>Ingrese su correo para mantenerse al día con nuestros últimos boletines y nuevas ofertas.</p>
          <div class="position-relative w-100 mt-3">
            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Correo" style="height: 48px;">
            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="container col-12">
      <div class="copyright">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 text-center mb-3 mb-md-0">
            &copy; <a class="border-bottom text-center" href="#">Astilleros del Caribe (ASTICAR)</a>, Todos los Derechos Reservados 2023.
            <br>Desarrollado por <a class="border-bottom" href="https://www.desoft.cu/es/divisiones">Empresa de Aplicaciones Informáticas, DESOFT, División Cienfuegos</a>
            <br>Diseñado con: <a class="border-bottom" href="https://vuejs.org/" target="_blank">Vue3</a> y <a class="border-bottom" href="https://getbootstrap.com/" target="_blank">Bootstrap 5</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->
</template>
<style scoped>

</style>
