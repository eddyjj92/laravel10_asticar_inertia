<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  solicitud: Object
});

const form = useForm({
  entidad: page.props.solicitud.entidad,
  correo: page.props.solicitud.correo,
  telefono: page.props.solicitud.telefono,
  solicitado_por: page.props.solicitud.solicitado_por,
  cargo_solicita: page.props.solicitud.cargo_solicita,
  recibido_por: page.props.solicitud.recibido_por,
  cargo_recibe: page.props.solicitud.cargo_recibe,
  servicio: page.props.solicitud.servicio.nombre,
  objeto_obra: page.props.solicitud.objeto_obra,
  trabajos_realizar: page.props.solicitud.trabajos_realizar,
  adicional: page.props.solicitud.adicional,
  fecha: page.props.solicitud.created_at
})

onMounted(()=>{

  setTimeout(()=>{
    window.print()
  },500);

  onafterprint = (event) => {
    window.close()
  };

})
</script>
<template>
  <main id="main" class="main">
    <div class="table-responsive m-4">
      <table style="border-width: 5px; border-color: black" class="table table-bordered table-responsive" id="printSolicitudTable">
        <thead>
        <tr style="min-height: 50px !important;">
          <th style="width: 40%" class="text-center"><img style="width: 100px; height: 40px" src="/img/asticar.png" alt="Astilleros del Caribe"></th>
          <th style="width: 30%" class="text-center fs-4 fw-bold fst-italic">Solicitud de Servicio</th>
          <th style="width: 30%" class="text-center">RG-11-02-01</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td colspan="3" class="text-center fs-5 fw-bold">Empresa Astilleros del Caribe (ASTICAR)</td>
        </tr>
        <tr style="height: 60px !important;">
          <td class="fw-bold">Proyecto No.</td>
          <td class="">Re: </td>
          <td class="text-center">Fecha: {{form.fecha}} </td>
        </tr>
        <tr style="height: 60px">
          <td colspan="1" class="fw-bold">Buque/Objeto de Obra: {{form.objeto_obra}}</td>
          <td colspan="2" class="fw-bold">Empresa: {{form.entidad}}</td>
        </tr>
        <tr>
          <td colspan="3" style="height: 490px !important;">
            <h4 class="fw-bold text-center">Trabajos a realizar:</h4>
            <p style="text-align: justify">{{form.trabajos_realizar}}</p>
          </td>
        </tr>
        <tr style="height: 60px !important;">
          <td class="fw-bold">Solicitado por: {{form.solicitado_por}}</td>
          <td class="fw-bold">Cargo: {{form.cargo_solicita}}</td>
          <td class="fw-bold">Firma: </td>
        </tr>
        <tr style="height: 60px !important;">
          <td class="fw-bold">Recibido por: {{form.recibido_por}}</td>
          <td class="fw-bold">Cargo: {{form.cargo_recibe}}</td>
          <td class="fw-bold">Firma: </td>
        </tr>
        <tr style="height: 60px !important;">
          <td colspan="1" class="text-center">
            <label class="my-1" for="escrita">Escrita: <input id="escrita" type="checkbox"></label><br>
            <label class="my-1" for="verbal">Verbal: <input id="verbal" type="checkbox"></label>
          </td>
          <td colspan="2" class="fw-bold">Adicional: {{form.adicional}} </td>
        </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<style>
 body{
   background-color: white;
 }
</style>
