<script setup lang="ts">
import * as linkify from "linkifyjs";
import DocumentSvg from "./svgs/DocumentSvg.vue";
import TrashSvg from "./svgs/TrashSvg.vue";
import EditSvg from "./svgs/EditSvg.vue";
import FavoriteSvg from "./svgs/FavoriteSvg.vue";
import UnFavoriteSvg from "./svgs/UnFavoriteSvg.vue";
import { computed } from "vue";

const emit = defineEmits(["delete", "edit", "favorite"]);

type Todo = {
  id: number;
  content: string;
  created_at: string;
  favorite: boolean;
};

const { todos } = defineProps<{
  todos: Todo[];
}>();

//url表示機能
const todoWithLinks = computed(() => {
  return todos.map((todo) => {
    return {
      ...todo,
      parts: linkify.tokenize(todo.content),
    };
  });
});

//

//削除
async function deleteMemo(id: number) {
  await fetch(`/api/memos/${id}`, {
    method: "DELETE",
  });

  emit("delete");
}
//

//編集
async function edit(id: number, content: string) {
  emit("edit", { id, content });
} //

//お気に入りボタンの状態変化
async function boolfavorite(id: number) {
  const response = await fetch(`/api/memos/${id}/favorite`, {
    method: "PATCH",
  });

  emit("favorite");
  return;
}
//
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
      <!--        //お気に入り部分-->
      <li v-for="todo in todoWithLinks" :key="todo.id">
        <div class="task" v-if="todo.favorite">
          <div class="favorite">
            <button v-if="todo.favorite" @click="boolfavorite(todo.id)">
              <FavoriteSvg />
            </button>

            <button v-else @click="boolfavorite(todo.id)">
              <UnFavoriteSvg />
            </button>

            <div class="strong">
              <template v-for="part in todo.parts">
                <a
                  v-if="part.t === 'url'"
                  :href="part.v"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="memo-link"
                >
                  {{ part.v }}
                </a>

                <span v-else>
                  {{ part.v }}
                </span>
              </template>
            </div>
          </div>

          <!--          <button @click="deleteMemo(todo.id)" class="trush">-->
          <!--            <TrashSvg />-->
          <!--          </button>-->

          <div class="week">
            {{ todo.created_at }}
          </div>

        </div>
      </li>
      <!--        //お気に入り部分　終-->

      <!--        //お気にいられてない部分　開-->
      <li v-for="todo in todoWithLinks" :key="todo.id">
        <div class="task" v-if="!todo.favorite">
          <div class="favorite">
            <button v-if="todo.favorite" @click="boolfavorite(todo.id)">
              <FavoriteSvg />
            </button>

            <button v-else @click="boolfavorite(todo.id)">
              <UnFavoriteSvg />
            </button>

            <div class="strong">
              <template v-for="part in todo.parts">
                <a
                  v-if="part.t === 'url'"
                  :href="part.v"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="memo-link"
                >
                  {{ part.v }}
                </a>

                <span v-else>
                  {{ part.v }}
                </span>
              </template>
            </div>
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
      <!--        //お気にいられていない部分　終-->
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
.favorite {
  display: flex;
  align-items: center;
  text-align: left;
}

.favorite button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  padding: 0;
  border: none;
  background: transparent;
  cursor: pointer;
}

.favorite svg {
  transform: scale(0.8);
}

.memo-link {
  color: #1976d2;
  text-decoration: underline;
  cursor: pointer;
}

.memo-link:hover {
  opacity: 0.7;
}
</style>
