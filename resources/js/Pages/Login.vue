<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import { ref, onMounted } from "vue";
import { useForm } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from "../Layouts/Layout.vue";
import Footer from "../Components/Footer.vue"

const { props } = usePage();

defineProps({
  configs: Object,
   errors: Object
});

const form = useForm({
  email: null,
  password: null,
  remember: false,
})

const options = {
  preserveScroll: true,
  onError: errors => {
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
    $('.bg-danger').show();
    setTimeout(()=>{
      $('.bg-danger').hide();
    }, 3000)
  },
}

</script>

<template>
  <div class="container-xxl bg-primary p-0">
    <Layout/>
    <div class="container-xxl py-6">
      <div class="container mt-1">
        <div class="row align-items-center justify-content-center py-4 g-5 my-8 mx-1">
          <div class="col-lg-5 wow fadeInUp my-8 border border-4 p-4 rounded rounded-5 bg-white " data-wow-delay="0.5s">
            <form @submit.prevent="form.post('/login',options)" class="p-2">
              <div class="row align-items-center justify-content-center g-3">
                <h2 class="text-center mb-1" style="color: black"><i class="bi bi-person-circle"></i> Ingresar Credenciales</h2>
                <img class="w-50 mb-1" src="img/asticar.png" alt="Logo">
                <div class="badge bg-danger fs-4" v-if="errors.credenciales"><i class="bi bi-x-circle-fill"></i> {{ errors.credenciales }}</div>
                <div class="col-12 mb-2">
                  <div class="form-floating">
                    <input v-model="form.email" type="text" class="form-control" id="user" placeholder="Subject">
                    <label for="user"><i class="bi bi-person-check"></i> Usuario</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <input v-model="form.password" type="password" class="form-control" id="pass" placeholder="Subject">
                    <label for="pass"><i class="bi bi-123"></i> Contraseña</label>
                  </div>
                </div>
                <div class="col-12 checkitem mb-2">
                  <input v-model="form.remember" type="checkbox" class="form-check" id="recordar" placeholder="Subject">
                  <label for="recordar" class="text-black">Recordar Credenciales</label>
                </div>
                <div class="col-12">
                  <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-key"></i> Acceder</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Footer :configs="configs" style="margin-top: -5px"/>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

 </template>
<style scoped>
.checkitem > label{
  display: inline-block;

  width: calc(100% - 52px);
  vertical-align: middle;
}

.checkitem > input[type=checkbox]{
  display: inline-block;
  width: 40px;
  height: 100%;
  vertical-align: middle;
}
</style>
