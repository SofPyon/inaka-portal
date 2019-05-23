<template>
    <div class="editor-wrap">
        <div class="alert alert-danger rounded-0 m-0 d-block d-md-none fixed-bottom text-center">
            申請フォームエディターは、パソコン上での編集にのみ対応しています。
        </div>
        <editor-loading v-show="!loaded" />
        <editor-header />
        <editor-content />
        <editor-sidebar />
    </div>
</template>

<script>
    import EditorLoading from './components/EditorLoading';
    import EditorHeader from './components/EditorHeader';
    import EditorContent from './components/EditorContent';
    import EditorSidebar from './components/EditorSidebar';
    import { FETCH } from "./store/editor";

    export default {
        components: {
            EditorLoading,
            EditorHeader,
            EditorContent,
            EditorSidebar,
        },
        async mounted() {
            await this.$store.dispatch('editor/' + FETCH);
        },
        computed: {
            loaded() {
                return this.$store.state.editor.loaded;
            },
        }
    };
</script>
