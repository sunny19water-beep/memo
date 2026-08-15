<script setup lang="ts">
import Header from './components/Header.vue'
import TextareaForm from './components/TextareaForm.vue'
import ContentDisplay from './components/ContentDisplay.vue'
import {ref,onMounted} from "vue";
type Todo = {
    id: number
    content: string
    created_at: string
    favorite: boolean
}
const todos = ref<Todo[]>([])
const editingMemo = ref<{ id: number, content: string } | null>(null)//開いた状態ではメモの中身がぞんざいしないためこのような記述になる

async function updateTodo() {//再取得　更新みたいなもの
    const response = await fetch('/api/memos')
    const data = await response.json()
    todos.value = data

}

onMounted(()=>{
    updateTodo() //最初に起動させるため
})

//編集
function senddata(data: { id: number, content: string }) {
  //Contentdisplay -> app.vue -> textareaform.vue
  editingMemo.value = data
}

function edittodo() {
  editingMemo.value = null
  updateTodo()
}
//




</script>

<template>
<!--  <router-view />-->
    <div class="background">
        <Header/>

        <TextareaForm
            @saved="updateTodo"
            @edited="edittodo"
            :editing-memo="editingMemo"
        />

        <ContentDisplay
            :todos="todos"
            @delete="updateTodo"
            @edit="senddata"
            @favorite="updateTodo"
        />
    </div>
</template>

<style scoped>
.background{
    background-color: #fbe2bd;
    min-height: 100vh;
}
</style>
