<template>
    <form-item class="question-text" :item_id="question_id">
        <template v-slot:content>
            <div class="form-group mb-0">
                <label>
                    {{ name }}
                    <span class="badge badge-danger">必須</span>
                </label>
                <input type="text" class="form-control" tabindex="-1">
                <small class="form-text text-muted">
                    {{ description }}
                </small>
            </div>
        </template>
        <template v-slot:edit-panel>
            <label class="form-group row">
                <span class="col-sm-2 col-form-label">設問名</span>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="name" />
                </div>
            </label>
            <label class="form-group row">
                <span class="col-sm-2 col-form-label">説明</span>
                <div class="col-sm-10">
                    <textarea class="form-control" v-model="description" />
                </div>
            </label>
        </template>
    </form-item>
</template>

<script>
    import FormItem from './FormItem';
    import { GET_QUESTION_BY_ID, UPDATE_QUESTION } from '../../store/editor';

    export default {
        props: {
            question_id: {
                required: true,
                type: Number,
            },
        },
        components: {
            FormItem,
        },
        computed: {
            question() {
                return this.$store.getters['editor/' + GET_QUESTION_BY_ID](this.question_id);
            },
            name: {
                get() {
                    return this.question.name;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question_id,
                        key: 'name',
                        value: new_value,
                    });
                }
            },
            description: {
                get() {
                    return this.question.description;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question_id,
                        key: 'description',
                        value: new_value,
                    });
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    .question-text {

    }
</style>
