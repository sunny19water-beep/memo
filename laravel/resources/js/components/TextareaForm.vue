<script setup lang="ts">
import { ref, watch } from "vue";
import PlusSvg from "./svgs/PlusSvg.vue";
import MicSvg from "./svgs/MicSvg.vue";
import AiSummarySvg from "./svgs/AiSummarySvg.vue";

const sentence = ref("");
const isRecording = ref(false);
const emit = defineEmits(["saved", "edited"]);
const status_summary = ref(false);

// 音声認識
const SpeechRecognition =
  (window as any).SpeechRecognition || (window as any).webkitSpeechRecognition;

const recognition = new SpeechRecognition();

recognition.lang = "ja-JP";
recognition.continuous = false;
recognition.interimResults = false;

function toggleRecognition() {
  if (isRecording.value) {
    recognition.stop();
  } else {
    recognition.start();
  }
}
recognition.onstart = () => {
  isRecording.value = true;
};

recognition.onend = () => {
  isRecording.value = false;
};

recognition.onresult = (event: any) => {
  const text = event.results[0][0].transcript;

  sentence.value = text;
};

//音声認識　終

//編集
type Memo = {
  id: number;
  content: string;
};

const props = defineProps<{
  editingMemo: Memo | null;
}>();

watch(
  () => props.editingMemo,
  (newMemo) => {
    if (newMemo) {
      sentence.value = newMemo.content;
    }
  },
);
//　編集終わり

//保存

async function save() {
  if (sentence.value.trim() === "") {
    return;
  }

  //編集部分のやつ
  if (props.editingMemo) {
    const memo = {
      content: sentence.value,
    };
    sentence.value = "";
    await fetch(`/api/memos/${props.editingMemo.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(memo),
    });
    emit("edited");

    return;
  }

  const memo = {
    content: sentence.value,
  }; //jsonで送るに向けてlaravel側の変数の名前を付けている

  sentence.value = "";

  const response = await fetch("/api/memos", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },

    body: JSON.stringify(memo),
  });

  emit("saved");
}
//

//AI要約
async function summarize() {
  if (sentence.value.length < 30) {
    return;
    //ここに30文字以上です...みたいなことを表示指せれたらしたい
  }
  status_summary.value = !status_summary.value;
  //ここにjsonの処理と返り値をテキストエリアに反映させる機能を書く

  status_summary.value = !status_summary.value;
}
</script>

<template>
  <div class="outside">
    <div class="title">
      <PlusSvg />
      <h2 v-if="editingMemo" class="change">編集中...　(メモを保存が押されたら更新されます）</h2>
      <h2 v-else-if="isRecording" class="change">録音中... (もう一回押すと録音は止まります）</h2>
      <h2 v-else-if="status_summary" class="change">AI要約中...(少々お待ちください）</h2>
      <h2 v-else>新しいメモ</h2>
    </div>

    <div class="content">
      <textarea
        id="memo-content"
        v-model="sentence"
        :class="{ active: sentence !== '' }"
        @keydown.enter.exact.prevent="save"
        placeholder="メモを入力してください...
またAI要約機能は30文字以上のときのみ使用できます
(Enterで保存、Shift+Enterで改行)"
      ></textarea>
    </div>

    <div class="save">
      <button @click="summarize">
        <AiSummarySvg />
        AI要約
      </button>

      <button @click="save" :disabled="sentence.trim() === ''">
        <PlusSvg />
        メモを保存
      </button>

      <button @click="toggleRecognition">
        <MicSvg />
        {{ isRecording ? "録音停止" : "音声入力" }}
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
  border: 1px solid #ffa726;
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

.title {
  display: flex;
  text-align: left;
  gap: 10px;
}

.content {
  margin-top: 15px;
  padding: 10px;
  border-radius: 10px;
}

textarea.active {
  border: 1px solid #c78f26;
}

.save {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  gap: 10px;
}

.save button {
  background-color: orange;
  color: #fff;
  display: flex;
  text-align: center;
  justify-content: center;
  align-items: center;
  padding: 10px;
  border-radius: 10px;
}

button:disabled {
  background-color: #ffa726;
}

.change {
  color: red;
}
</style>
