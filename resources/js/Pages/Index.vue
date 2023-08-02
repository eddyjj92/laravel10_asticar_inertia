<script setup>
import { Link } from '@inertiajs/vue3'
import Layout from "../Layouts/Layout.vue";
import HeroSection from "../Components/HeroSection.vue";
import FeatureSection from "../Components/FeatureSection.vue";
import BlogSection from "../Components/BlogSection.vue";
import ContactSection from "../Components/ContactSection.vue";
import Footer from "../Components/Footer.vue"

defineProps({
    images:Object,
    configs: Object,
    servicios: Object,
    noticias: Object,
  });

</script>

<template>

  <div class="container-xxl bg-white p-0">
    <Layout/>
    <HeroSection :images="images" :configs="configs"/>
    <FeatureSection :configs="configs" :servicios="servicios"/>
    <BlogSection :noticias="noticias"/>
    <ContactSection :configs="configs"/>
    <div class="container-fluid bg-light">
      <div class="w-100">
        <iframe
          src="https://maps.google.com/maps?q=Astillero+Punta+Gotica&t=&z=13&ie=UTF8&iwloc=&output=embed"
          class="w-100" height="400" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
    <Footer :configs="configs" style="margin-top: -5px"/>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

 </template>
