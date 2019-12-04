<template>
    <div
        class="form-item"
        :class="{'form-item--active': is_edit_panel_open, 'form-item--drag': drag, 'form-item--saving': is_saving}"
        :ref="`form_item_${item_id}`"
    >
        <div class="form-item__handle" v-if="!hide_handle && !is_saving">
            <i class="fas fa-grip-horizontal"></i>
        </div>
        <div class="form-item__content" @click="toggle_open_state">
            <div class="form-item__content__inner">
                <slot name="content" />
            </div>
        </div>
        <div class="form-item__edit-panel" :class="{'form-item__edit-panel--open': is_edit_panel_open}">
            <slot name="edit-panel" />
        </div>
    </div>
</template>

<script>
    import { TOGGLE_OPEN_STATE, SAVE_STATUS_SAVING, ITEM_HEADER } from "../../store/editor";

    export default {
        props: {
            item_id: {
                required: true,
            },
            hide_handle: {
                required: false,
                type: Boolean,
                default: false,
            },
        },
        computed: {
            is_saving() {
                return this.$store.state.editor.save_status === SAVE_STATUS_SAVING;
            },
            drag() {
                return this.$store.state.editor.drag;
            },
            is_edit_panel_open() {
                return this.$store.state.editor.open_item_id === this.item_id;
            },
        },
        watch: {
            is_edit_panel_open(value) {
                if (value) {
                    this.scroll_to_me();
                }
            }
        },
        created() {
            if (this.is_edit_panel_open) {
                this.scroll_to_me();
            }
        },
        methods: {
            toggle_open_state() {
                this.$store.commit('editor/' + TOGGLE_OPEN_STATE, {
                    item_id: this.item_id,
                });
            },
            scroll_to_me() {
                this.$nextTick(() => {
                    const top = this.$refs[`form_item_${this.item_id}`].getBoundingClientRect().top +  window.scrollY
                        - document.querySelector('.editor-header').getBoundingClientRect().bottom - 16;
                    console.log(top);
                    window.scroll({
                        top,
                        behavior: 'smooth',
                    });
                });
            }
        }
    };
</script>

<style lang="scss" scoped>
    $form-item-padding: 1.5rem;

    .form-item {
        box-shadow: none;
        transition: .25s ease box-shadow, .25s ease z-index;
        position: relative;
        z-index: 10;

        &__handle {
            cursor: move;
            display: none;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: .25rem;
            color: #a7a7a7;
        }

        &:hover:not(&--drag):not(&--saving),
        &--active {
            box-shadow: 0 .25rem 1rem rgba(0, 0, 0, .2);
        }

        &:hover:not(&--active):not(&--saving) {
            z-index: 20;
        }

        &:hover &__handle {
            display: block;
        }

        &--active {
            z-index: 15;
        }

        &__content {
            padding: $form-item-padding;
            cursor: pointer;
            background: #fff;

            &__inner {
                pointer-events: none;
                user-select: none;
            }
        }

        &__edit-panel {
            display: none;
            padding: $form-item-padding;
            overflow: hidden;
            box-shadow: inset 0 .3rem .25rem -.2rem rgba(0, 0, 0, .07);
            background: lighten(#f8fafc, 1%);
            border-bottom: 1px solid #f8fafc;
            
            &--open {
                display: block;
            }
        }
    }
</style>