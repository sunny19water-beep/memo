<script setup lang="ts">
import { ref } from 'vue'
import PlusSvg from './svgs/PlusSvg.vue'

const sentence = ref('');
const contents = ref([{
    content:'NULL'
}]);
const id = ref(1);

async　function save() {
    if (sentence.value.trim() === '') {
        return;
    }

    const memo = {
        content: sentence.value
    }//jsonで送るに向けてlaravel側の変数の名前を付けている

    const response = await fetch('/api/memos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },

        body: JSON.stringify(memo)
    })
    contents.value.push({

        content: sentence.value
    });

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
              @keydown.enter.exact.prevent="save"
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
    width: 90%;
    max-width: 700px;
    margin: 0 auto;

    border-radius: 10px;
    border: 1px solid #FFA726;
    background-color: #fff;
    padding: 20px;
    box-sizing: border-box;
}

textarea {
    width: 100%;
    height: 150px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px;
    resize: none;
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


textarea.active{
    border: 1px solid #c78f26;
}

.save {
    margin-top: 20px;
    display: flex;
    justify-content: center;
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
