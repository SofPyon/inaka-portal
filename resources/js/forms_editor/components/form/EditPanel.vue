<template>
    <div class="edit-panel">
        <div class="row mb-2">
            <div class="offset-sm-2 col-sm-10">
                <label class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" v-model="is_required" :disabled="is_saving">
                    <span class="custom-control-label">回答必須</span>
                </label>
            </div>
        </div>
        <label class="form-group row">
            <span class="col-sm-2 col-form-label">設問名</span>
            <div class="col-sm-10">
                <input type="text" class="form-control" v-model="name" @blur="save" :disabled="is_saving" />
            </div>
        </label>
        <label class="form-group row">
            <span class="col-sm-2 col-form-label">説明</span>
            <div class="col-sm-10">
                <textarea class="form-control" v-model="description" @blur="save" :disabled="is_saving" />
            </div>
        </label>
        <label class="form-group row">
            <span class="col-sm-2 col-form-label">最小文字数</span>
            <div class="col-sm-10">
                <input type="number" min="0" class="form-control" v-model="number_min" @blur="save" :disabled="is_saving" />
            </div>
        </label>
        <label class="form-group row">
            <span class="col-sm-2 col-form-label">最大文字数</span>
            <div class="col-sm-10">
                <input type="number" min="0" class="form-control" v-model="number_max" @blur="save" :disabled="is_saving" />
            </div>
        </label>
    </div>
</template>

<script>
    import { UPDATE_QUESTION, SAVE_QUESTION, SAVE_STATUS_SAVING } from '../../store/editor';

    export default {
        props: {
            question: {
                required: true,
            }
        },
        methods: {
            save() {
                this.$store.dispatch('editor/' + SAVE_QUESTION, this.question.id);
            }
        },
        computed: {
            is_saving() {
                return this.$store.state.editor.save_status === SAVE_STATUS_SAVING;
            },
            name: {
                get() {
                    return this.question.name;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question.id,
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
                        id: this.question.id,
                        key: 'description',
                        value: new_value,
                    });
                }
            },
            is_required: {
                get() {
                    return this.question.is_required;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question.id,
                        key: 'is_required',
                        value: new_value,
                    });
                    this.save();
                }
            },
            number_min: {
                get() {
                    return this.question.number_min;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question.id,
                        key: 'number_min',
                        value: new_value,
                    });
                }
            },
            number_max: {
                get() {
                    return this.question.number_max;
                },
                set(new_value) {
                    this.$store.commit('editor/' + UPDATE_QUESTION, {
                        id: this.question.id,
                        key: 'number_max',
                        value: new_value,
                    });
                }
            },
        }
    };
</script>
