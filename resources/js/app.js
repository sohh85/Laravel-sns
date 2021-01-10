import './bootstrap'
import Vue from 'vue'
import ArticleLike from './components/ArticleLike'
import ArticleTagsInput from './components/ArticleTagsInput'

// blade内で使用するため、vueコンポーネントを定義
const app = new Vue({
    el: '#app',
    components: {
        ArticleLike,
        ArticleTagsInput,
    }
})