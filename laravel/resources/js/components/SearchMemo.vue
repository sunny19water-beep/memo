<script setup lang="ts">
import { ref } from "vue";
import SearchSvg from "./svgs/SearchSvg.vue";
import DocumentSvg from "./svgs/DocumentSvg.vue";

const search_word = ref("");

function search() {
  //ここで検索の処理の内容を記述する
}

</script>

<template>
  <div class="outside">

    <div class="title">
      <DocumentSvg />
      <h1>お探しですか？</h1>
    </div>

    <div class="search">
      <div class="search-box">
        <SearchSvg />

        <input
          v-model="search_word"
          type="text"
          placeholder="メモを検索..."
        />

        <button @click="search_word">
          検索
        </button>
      </div>
    </div>

  </div>
</template>

<style scoped>
.outside {
  width: 90%;
  max-width: 700px;
  margin: 0 auto;

  padding: 20px;

  border: 1px solid #ffa726;
  border-radius: 10px;

  background-color: #fff;
  box-sizing: border-box;
}


.title {
  display: flex;
  align-items: center;
  gap: 10px;

  margin-bottom: 15px;
}

.title h1 {
  margin: 0;
  font-size: 20px;
}

/* 検索欄 */
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

/* 検索欄にカーソルを入れたとき */
.search-box:focus-within {
  border-color: transparent;
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.2);
}

/* 検索アイコン */
.search-box :deep(svg) {
  width: 20px;
  height: 20px;
}

/* 入力欄 */
.search-box input {
  flex: 1;

  height: 100%;

  padding: 0 10px;

  border: none;
  outline: none;

  font-size: 15px;
}

/* 検索ボタン */
.search-box button {
  padding: 7px 14px;

  border: none;
  border-radius: 18px;

  background-color: #ffa726;
  color: white;

  cursor: pointer;

  transition: 0.2s;
}

.search-box button:hover {
  background-color: #fb8c00;
}

.search-box button:active {
  transform: scale(0.95);
}
</style>
