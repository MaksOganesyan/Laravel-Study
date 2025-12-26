<template>
    <div v-if="article != null" class="alert alert-primary" role="alert">
        Добавлена новая статья <strong><a :href="`/article/${article.id}`">{{ article.name }}</a></strong>
    </div>
</template>

<script>
export default {
    data() { return { article: null } },
   created() {
    if (window.Echo) {
        window.Echo.channel('test')
            .listen('NewArticleEvent', (e) => {
                console.log('Event received:', e); // <--- смотри сюда
                this.article = e.article;
            });
    } else {
        console.error('Echo не инициализирован');
    }
}

}
</script>
