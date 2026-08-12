<script setup lang="ts">
import Header from './components/Header.vue'
import TextareaForm from './components/TextareaForm.vue'
import ContentDisplay from './components/ContentDisplay.vue'
import {ref,onMounted} from "vue";
type Todo = {
    id: number
    content: string
    created_at: string
}
const todos = ref<Todo[]>([])

async function updateTodo() {
    const response = await fetch('/api/memos')
    const data = await response.json()//ここのデータは緩衝材になっているんだね
    //デバック始
    console.log(data)
    console.log(data.content)
    //デバック終
    todos.value = data

}

onMounted(()=>{
    updateTodo()
})

</script>

<template>
<!--  <router-view />-->
    <div class="background">
        <Header/>
        <TextareaForm @saved="updateTodo"/>
        <ContentDisplay :todos="todos" @delete="updateTodo" />
    </div>
</template>

<style scoped>
.background{
    background-color: #fbe2bd;
    min-height: 100vh;
}
</style>
