<script setup>
import {ref} from "vue";
import 'vue3-carousel/dist/carousel.css'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue';
const { props } = usePage();

defineProps({
  images:Object,
  configs: Object,
  servicios: Object
});

</script>

<template>
  <div class="container-xxl py-5" id="about">
    <div class="container">
      <div class="row g-4">
        <a href="#" class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
          <div class="feature-item bg-light rounded text-center p-5">
            <img width="150" src="img/asticar.png" class="mb-3" alt="Logo">
            <h5 class="mb-3 text-uppercase">ASTICAR</h5>
            <p class="m-0 text-uppercase ">Empresa Astilleros del Caribe</p>
          </div>
        </a>
        <a href="https://www.gemar.transnet.cu/" class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
          <div class="feature-item bg-light rounded text-center p-5">
            <img width="150" src="img/gemar.png" class="mb-3" alt="Logo">
            <h5 class="mb-3 text-uppercase">Grupo GEMAR</h5>
            <p class="m-0 text-uppercase">GRUPO EMPRESARIAL DE TRANSPORTE MARÍTIMO PORTUARIO</p>
          </div>
        </a>
        <a href="https://www.mitrans.gob.cu/" class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
          <div class="feature-item bg-light rounded text-center p-5">
            <img width="150" src="img/mitrans.png" class="mb-3" alt="Logo">
            <h5 class="mb-3 text-uppercase">MITRANS</h5>
            <p class="m-0 text-uppercase">Ministerio del Transporte</p>
          </div>
        </a>
      </div>
    </div>
  </div>
  <!-- Feature End -->


  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5 flex-column-reverse flex-lg-row">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <h2 class="mb-4">{{configs[1].config.titulo}}</h2>
          <p class="mb-4" style="text-align: justify">{{configs[1].config.descripcion}}</p>
          <div v-for="service in servicios" class="d-flex">
            <p class="fs-6"><i class="fa fa-check-circle text-primary"></i> <span class="fw-bold">{{ service.nombre }}</span>, {{ service.descripcion }}</p>
          </div>
        </div>
        <div class="col-lg-6">
          <img class="img-fluid rounded wow zoomIn w-100" style="min-height: 400px" data-wow-delay="0.5s" :src="`img/portadas/${configs[1].config.imagen}`">
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Process Start -->
  <div class="container-xxl bg-light py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <img class="w-100 img-fluid rounded" style="min-height:400px" src="img/ecommerce600x400.png">
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <h2 class="mb-4">Pasos a seguir para acceder a nuestros servicios</h2>
          <p class="mb-4">A través de nuestra página web puede solicitar y acceder a todos los productos y servicios que ofrece nuestra empresa.</p>
          <ul class="process mb-0">
            <li>
              <span><i class="fa fa-cog"></i></span>
              <div>
                <h5>Acceder a nuestra página web</h5>
                <p>Lea toda la documentación que ponemos a su disposición. </p>
              </div>
            </li>
            <li>
              <span><i class="fa fa-address-card"></i></span>
              <div>
                <h5>Creación de una cuenta</h5>
                <p>Contacte con nuestro equipo comercial por las vías disponibles y envíe un documento con los datos de la empresa y la persona autorizada a realizar solicitudes.</p>
              </div>
            </li>
            <li>
              <span><i class="fa fa-check"></i></span>
              <div>
                <h5>Solicitar Servicios</h5>
                <p>Realice las solicitudes requeridas en el menú servicios, debe estar previamente auntenticado en el sistema. </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Process End -->
</template>

<style scoped>

</style>
