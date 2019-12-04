<template>
    <div class="editor-wrap">
        <div class="alert alert-danger rounded-0 m-0 d-block d-md-none fixed-bottom text-center">
            申請フォームエディターは、パソコン上での編集にのみ対応しています。
        </div>
        <editor-loading v-show="!loaded" />
        <editor-header />
        <editor-content />
        <editor-sidebar />
        <editor-error v-show="is_error" />
    </div>
</template>

<script>
    import EditorLoading from './components/EditorLoading';
    import EditorHeader from './components/EditorHeader';
    import EditorContent from './components/EditorContent';
    import EditorSidebar from './components/EditorSidebar';
    import EditorError from './components/EditorError';
    import { FETCH, SAVE_STATUS_SAVING, TOGGLE_OPEN_STATE, ITEM_HEADER } from "./store/editor";

    const on_before_unload = event => {
        event.preventDefault();
        event.returnValue = '';
    };

    export default {
        components: {
            EditorLoading,
            EditorHeader,
            EditorContent,
            EditorSidebar,
            EditorError,
        },
        async mounted() {
            await this.$store.dispatch('editor/' + FETCH);
            if (this.$store.state.editor.questions.length === 0) {
                this.$store.commit('editor/' + TOGGLE_OPEN_STATE, { item_id: ITEM_HEADER });
            }
        },
        computed: {
            loaded() {
                return this.$store.state.editor.loaded;
            },
            is_error() {
                return this.$store.state.editor.is_error;
            },
            is_saving() {
                return this.$store.state.editor.save_status === SAVE_STATUS_SAVING;
                // is_saving の状態は、以下で watch されている
            },
        },
        watch: {
            is_saving(value) {
                if (value) {
                    window.addEventListener('beforeunload', on_before_unload);
                } else {
                    window.removeEventListener('beforeunload', on_before_unload);
                }
            },
            is_error(value) {
                if (value) {
                    window.removeEventListener('beforeunload', on_before_unload);
                }
            }
        }
    };
</script>
