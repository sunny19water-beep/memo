<script setup lang="ts">
import { ref } from "vue";
import SearchSvg from "./svgs/SearchSvg.vue";
const emit = defineEmits(["searched", "initialize"]);

const search_word = ref("");
const status = ref(false);

async function search() {
  const response = await fetch(`/api/memos?search=${encodeURIComponent(search_word.value)}`);

  const data = await response.json();

  emit("searched", data);
  status.value = !status.value;
}

function initialize() {
  search_word.value = "";
  status.value = !status.value;
  emit("initialize");
}
</script>

<template>
  <div class="outside">
    <div class="search">
      <div class="search-box">
        <SearchSvg />

        <input v-model="search_word" type="text" placeholder="メモを検索..." />

        <button v-if="status" @click="search" :disabled="search_word === ''">検索</button>
        <button v-else @click="initialize">リセット</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.outside {
  width: 90%;
  max-width: 700px;
  margin: 20px auto;

  padding: 13px;

  border: 1px solid #ffa726;
  border-radius: 10px;

  background-color: #fff;
  box-sizing: border-box;
}

.search {
  display: flex;
  justify-content: center;
}

.search-box {
  display: flex;
  align-items: center;

  width: 100%;
  max-width: 550px;
  height: 42px;

  padding: 0 8px 0 14px;

  border: 1px solid #d0d0d0;
  border-radius: 24px;

  box-sizing: border-box;

  transition: box-shadow 0.2s;
}

.search-box :deep(svg) {
  width: 20px;
  height: 20px;
}

.search-box input {
  flex: 1;
  height: 100%;
  padding: 0 10px;
  border: none;
  outline: none;
  font-size: 15px;
}

.search-box button {
  padding: 7px 14px;
  border: none;
  border-radius: 18px;
  background-color: #ffa726;
  color: white;
  transition: 0.2s;
}
</style>
