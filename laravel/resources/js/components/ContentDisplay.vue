<script setup lang="ts">
import DocumentSvg from "./svgs/DocumentSvg.vue";
import TrashSvg from "./svgs/TrashSvg.vue";
import EditSvg from "./svgs/EditSvg.vue";
import FavoriteSvg from "./svgs/FavoriteSvg.vue";
import UnFavoriteSvg from "./svgs/UnFavoriteSvg.vue";

const emit = defineEmits(["delete", "edit","favorite"]);

type Todo = {
  id: number;
  content: string;
  created_at: string;
  favorite: boolean;
};

const { todos } = defineProps<{
  todos: Todo[];
}>();
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
  // if (todos[id].favorite) {
  //   await fetch(`/api/memos/${id}`, {
  //     method: "PATCH",
  //     headers: {
  //       "Content-Type": "application/json",
  //     },
  //     body: JSON.stringify({
  //       favorite: false,
  //     }),
  //   });
  // } else {
  //   await fetch(`/api/memos/${id}`, {
  //     method: "PATCH",
  //     headers: {
  //       "Content-Type": "application/json",
  //     },
  //     body: JSON.stringify({
  //       favorite: true,
  //     }),
  //   });
  // }

    const response = await fetch(`/api/memos/${id}/favorite`, {
        method: "PATCH",
    });

  emit("favorite")
    return
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
      <li v-for="todo in todos" :key="todo.id">
        <div class="task">
          <div class="favorite">
            <button v-if="todo.favorite" @click="boolfavorite(todo.id)">
              <FavoriteSvg />
            </button>

            <button v-else @click="boolfavorite(todo.id)">
              <UnFavoriteSvg />
            </button>

            <div class="strong">
              {{ todo.content }}
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
</style>
