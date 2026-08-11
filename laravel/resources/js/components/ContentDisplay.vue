<script setup lang="ts">
import DocumentSvg from './svgs/DocumentSvg.vue'
import TrashSvg from './svgs/TrashSvg.vue'
// import { ref } from 'vue'

type Todo = {
    id: number
    content: string
    created_at: string
}
// // このページに訪れたときに実行
// const todos = ref<Todo[]>([])
// const response = await fetch('/api/memos')
// const data = await response.json()
// todos.value = data

const { todos } = defineProps<{
    todos: Todo[]
}>()

// //Memoが追加された際に実行
// async function updateTodo() {
//     const response = await fetch('/api/memos')
//     const data = await response.json()
//     todos.value = data
// }

// // ------これはmockデータです------ //
// // これは本番のDBから持ってくる
// const todos = ref([
//     {
//         id: 1,
//         title: 'Vueの勉強をする',
//         created_at: '2026-08-11 10:00:00'
//     },
//     {
//         id: 2,
//         title: 'LaravelのAPIを作る',
//         created_at: '2026-08-10 15:30:00'
//     }
// ])
//
// const count = ref()
// //------ここまでがmockデータです------ //


</script>

<template>
    <div class="all">
        <div class="title">
            <DocumentSvg/>
            <h1>保存されたメモ</h1>
            <div class="memo_count">
                    <p>{{todos.length}}件</p>
            </div>
        </div>

        <ul>
            <li v-for="todo in todos" :key="todo.id">
                <div class="task">
                    <div class="strong">{{ todo.content}}</div>
                        <button class="trush">
                            <TrashSvg/>
                        </button>
                    <div class="week">{{todo.created_at}}</div>
                </div>
            </li>
        </ul>



    </div>



</template>

<style scoped>
.all{
    width: 90%;
    max-width: 700px;
    margin: 0 auto;
}
.title{
    display: flex;
    gap: 10px;
    justify-content: flex-start;
    margin-bottom: 10px;
    margin-top: 20px;
}

.title .memo_count{
    padding-top:5px;
    padding-bottom:5px;
    padding-left:3px;
    padding-right:3px;
    border-radius: 10px;
    border : 1px solid black;
    margin-left: auto;
    background-color: #d6cdbf;
}

.task {
    position: relative;
    border-radius: 5px;
    padding: 10px;
    background-color: #f5f5f5;
    margin-bottom: 10px;
}

.trush {
    display: none;
    position: absolute;
    top: 15px;
    right: 15px;
}

.task:hover .trush {
    display: block;
}
.task .strong{
    font-weight: 400;
    text-align: left;
}

.task .week{
    font-size: 14px;
    color: #888;
    text-align: left;
}



</style>
