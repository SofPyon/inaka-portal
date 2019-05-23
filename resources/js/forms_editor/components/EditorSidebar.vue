<template>
    <div class="editor-sidebar editor-sidebar-styling">
        <div class="editor-sidebar__header bg-gradient-secondary text-white">ツールパレット</div>
    </div>
</template>

<style lang="scss" scoped>
    $editor-sidebar-padding: 1rem;

    .editor-sidebar {
        background: #fff;
        box-shadow: -.1rem 0 .1rem rgba(0, 0, 0, 0.07);

        &__header {
            padding: $editor-sidebar-padding;
        }
    }
</style>
