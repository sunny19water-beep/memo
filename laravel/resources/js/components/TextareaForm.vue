<script setup lang="ts">
import { ref } from 'vue'
import PlusSvg from './svgs/PlusSvg.vue'

const content = ref('')
// const contents=[
//
// ]
//
// function save(){
//
// }


</script>

<template>
    <div class="outside">

        <div class="title">
            <PlusSvg />
            <h2>新しいメモ</h2>
        </div>

        <div class="content">
          <textarea
              v-model="content"
              placeholder="メモを入力してください...
    (Enterで保存、Shift+Enterで改行)"
          ></textarea>
        </div>

        <div class="save">
            <button>
                <PlusSvg />
                メモを保存
            </button>
        </div>
    </div>
</template>

<style scoped>
.outside{
    border-radius: 10px;
    background-color: #fff;
    padding: 20px;
}

.title{
    display: flex;
    text-align: left;
    gap: 10px;
}
.content{
    margin-top: 15px;
    padding: 10px;
    border-radius: 10px;
}

.save {
    margin-top: 20px;
}

.save button{
    background-color: orange;
    color: #fff;
    display: flex;
    text-align:center;
    justify-content: center;
    align-items: center;
    padding: 10px;
    border-radius: 10px;
}
</style>
