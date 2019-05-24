<template>
    <div class="editor-sidebar editor-sidebar-styling">
        <div class="editor-sidebar__header bg-gradient-secondary text-white">ツールパレット</div>
        <div class="editor-sidebar__body">
            <div class="editor-sidebar__tools">
                <button v-for="tool in tools" :key="tool.type" class="btn editor-sidebar__tool border-light">
                    <i :class="`${tool.icon} fa-fw text-muted editor-sidebar__tool__icon`"></i>
                    <span class="editor-sidebar__tool__label">{{ tool.label }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            tools() {
                return [
                    {
                        type: 'heading',
                        icon: 'fas fa-heading',
                        label: 'セクション見出し',
                    },
                    {
                        type: 'text',
                        icon: 'fas fa-grip-lines',
                        label: '一行入力',
                    },
                    {
                        type: 'number',
                        icon: 'fas fa-dice',
                        label: '整数入力',
                    },
                    {
                        type: 'textarea',
                        icon: 'fas fa-align-justify',
                        label: '複数行入力',
                    },
                    {
                        type: 'radio',
                        icon: 'far fa-dot-circle',
                        label: '単一選択(ラジオボタン)',
                    },
                    {
                        type: 'select',
                        icon: 'far fa-list-alt',
                        label: '単一選択(ドロップダウン)',
                    },
                    {
                        type: 'checkbox',
                        icon: 'far fa-check-square',
                        label: '複数選択(チェックボックス)',
                    },
                    {
                        type: 'upload',
                        icon: 'far fa-file',
                        label: 'ファイルアップロード',
                    },
                ];
            }
        }
    }
</script>

<style lang="scss" scoped>
    $editor-sidebar-padding: 1rem;

    .editor-sidebar {
        background: #fff;
        box-shadow: -.1rem 0 .1rem rgba(0, 0, 0, 0.07);
        display: flex;
        flex-direction: column;

        &__header {
            padding: $editor-sidebar-padding;
        }

        &__body {
            flex: 1;
            overflow-x: hidden;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
            padding: $editor-sidebar-padding;
        }

        &__tool {
            width: 100%;
            box-shadow: 0 .1rem .1rem rgba(0, 0, 0, 0.07);
            margin-bottom: $editor-sidebar-padding;
            display: flex;
            flex-direction: column;
            align-items: center;

            &:last-child {
                margin-bottom: 0;
            }

            &:hover {
                background: #f2f2f2;
            }

            &__icon {
                font-size: 1.25rem;
                margin-bottom: $editor-sidebar-padding / 2;
            }
        }
    }
</style>
