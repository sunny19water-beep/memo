<script setup lang="ts">
import Header from './components/Header.vue'
import TextareaForm from './components/TextareaForm.vue'
import ContentDisplay from './components/ContentDisplay.vue'
</script>

<template>
<!--  <router-view />-->
    <div class="background">
        <Header/>
        <TextareaForm/>
        <ContentDisplay/>
    </div>
</template>

<style scoped>
.background{
    background-color: #fbe2bd;
    min-height: 100vh;
}
</style>
