<script setup lang="ts">
import DocumentSvg from './svgs/DocumentSvg.vue'
</script>

<template>
    <header>
        <div class="title">
            <DocumentSvg/><h1 class="co">かんたんメモ</h1>
        </div>
        <p>思いついたことをサッと記録しよう</p>
    </header>
</template>

<style scoped>
.title{
    color: orange;
    display: flex;
    justify-content: center;
}
header{
    padding: 20px;
    text-align: center;
    font-size: 100%;
    background-color: #f8cf91;
    margin-bottom: 20px;
}
</style>

