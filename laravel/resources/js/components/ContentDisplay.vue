<script setup lang="ts">
import DocumentSvg from "./svgs/DocumentSvg.vue";
import TrashSvg from "./svgs/TrashSvg.vue";
import EditSvg from "./svgs/EditSvg.vue";
import { ref } from "vue";
// import { ref } from 'vue'
const emit = defineEmits(["delete", "edit"]);

type Todo = {
  id: number;
  content: string;
  created_at: string;
};

const { todos } = defineProps<{
  todos: Todo[];
}>();

async function deleteMemo(id: number) {
  await fetch(`/api/memos/${id}`, {
    method: "DELETE",
  });
  emit("delete");
}

async function edit(id: number, content: string) {
  // このかんすうでテキストエリアに表示させるようにしたい
  //propsとemitで全部textarea.Vueに渡せばいい
  emit("edit", { id, content });

}
</script>

<template>
  <div class="all">
    <div class="title">
      <DocumentSvg />
      <h1>保存されたメモ</h1>
      <div class="memo_count">
        <p>{{ todos.length }}件</p>
      </div>
    </div>

    <ul>
      <li v-for="todo in todos" :key="todo.id">
        <div class="task">
          <div class="strong">
            {{ todo.content }}
          </div>

          <button @click="deleteMemo(todo.id)" class="trush">
            <TrashSvg />
          </button>

          <div class="week">
            {{ todo.created_at }}
          </div>

          <div class="Edit" @click="edit(todo.id, todo.content)">
            <EditSvg />
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.all {
  width: 90%;
  max-width: 700px;
  margin: 0 auto;
}
.title {
  display: flex;
  gap: 10px;
  justify-content: flex-start;
  margin-bottom: 10px;
  margin-top: 20px;
}

.title .memo_count {
  padding: 5px 3px;
  border-radius: 10px;
  border: 1px solid black;
  margin-left: auto;
  background-color: #d6cdbf;
}

.task {
  position: relative;
  border-radius: 5px;
  padding: 10px;
  background-color: #f5f5f5;
  margin-bottom: 10px;
  white-space: pre-wrap;
}

.task .strong {
  font-weight: 400;
  text-align: left;
}

.task .week {
  font-size: 14px;
  color: #888;
  text-align: left;
}

.trush {
  display: none;
  position: absolute;
  top: 10px;
  right: 15px;
}

.Edit {
  display: none;
  position: absolute;
  top: 35px;
  right: 10px;
}

.task:hover .trush,
.task:hover .Edit {
  display: block;
}
</style>
