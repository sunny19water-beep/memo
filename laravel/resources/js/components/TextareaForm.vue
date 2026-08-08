<script setup lang="ts">
import { ref } from 'vue'
import PlusSvg from './svgs/PlusSvg.vue'

const sentence = ref('');
const contents = ref([{
    id:0,
    content:'NULL'
}]);
const id = ref(1);

function save() {
    if (sentence.value.trim() === '') {
        return;
    }

    contents.value.push({
        id: id.value,
        content: sentence.value
    });

    id.value++;
    sentence.value = '';
}

</script>


<template>
    <div class="outside">

        <div class="title">
            <PlusSvg />
            <h2>新しいメモ</h2>
        </div>

        <div class="content">
          <textarea
              id="memo-content"
              v-model="sentence"
              :class="{ active: sentence !== '' }"
              placeholder="メモを入力してください...
    (Enterで保存、Shift+Enterで改行)"
          ></textarea>
        </div>

        <div class="save">
            <button @click="save"
                    :disabled="sentence.trim() === ''">
                <PlusSvg />
                メモを保存
            </button>
        </div>

    </div>
</template>

<style scoped>


.outside {
    border-radius: 10px;
    border: 3px solid red;
    background-color: #fff;
    padding: 20px;
    text-align:center;
    justify-content: center;
    align-items: center;
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

textarea{
    border: 1px solid #ccc;
}

textarea.active{
    border: 1px solid orange;
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

button:disabled {
    background-color: #FFA726; /* 元のオレンジ */
}
</style>
