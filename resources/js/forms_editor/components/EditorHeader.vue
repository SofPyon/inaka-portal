<template>
  <header class="editor-header editor-header-styling">
    <div class="editor-header__title">
      申請フォームエディター
    </div>
    <div class="editor-header__status" v-if="!is_error">
      <span class="text-muted editor-header__status__saving" v-if="is_saving">
        <i class="fas fa-sync fa-spin fa-fw"></i>
        保存中...
        <template v-if="request_queued_count > 1">
          ({{ request_queued_count }} 件処理中)
        </template>
      </span>
      <span class="text-success editor-header__status__saved" v-if="is_saved">
        <i class="fas fa-check fa-fw"></i>
        保存しました
      </span>
    </div>
    <div class="editor-header__status" v-else>
      <span class="text-danger editor-header__status__error">
        <i class="fas fa-exclamation-circle fa-fw"></i>
        エラーが発生しました
      </span>
    </div>
    <div class="editor-header__actions">
      <a class="btn btn-link" :href="preview_url" target="_blank">プレビュー</a>
      <template v-if="is_public">
        <span class="badge badge-primary mr-2">公開</span>
        <button
          class="btn btn-danger"
          :disabled="is_saving"
          v-on:click="togglePublic()"
        >
          非公開にする
        </button>
      </template>
      <template v-else>
        <span class="badge badge-danger mr-2">非公開</span>
        <button
          class="btn btn-primary"
          :disabled="is_saving"
          v-on:click="togglePublic()"
        >
          公開する
        </button>
      </template>
    </div>
  </header>
</template>

<script>
import { SAVE_STATUS_SAVING, SAVE_STATUS_SAVED } from '../store/status'
import { SET_FORM_PUBLIC, SET_FORM_PRIVATE, SAVE_FORM } from '../store/editor'

export default {
  computed: {
    save_status() {
      return this.$store.state.status.save_status
    },
    is_saving() {
      return this.save_status === SAVE_STATUS_SAVING
    },
    request_queued_count() {
      return this.$store.state.status.request_queued_count
    },
    is_saved() {
      return this.save_status === SAVE_STATUS_SAVED
    },
    is_error() {
      return this.$store.state.status.is_error
    },
    preview_url() {
      const form_id = this.$store.state.editor.form.id
      return `/home_staff/applications/preview/${form_id}`
    },
    is_public() {
      return this.$store.state.editor.form.is_public
    }
  },
  methods: {
    save() {
      this.$store.dispatch(`editor/${SAVE_FORM}`)
    },
    togglePublic() {
      if (
        window.confirm(
          this.$store.state.editor.form.is_public
            ? '非公開にしますか？'
            : '公開しますか？\n公開しても受付期間まで回答することはできません。'
        )
      ) {
        if (this.$store.state.editor.form.is_public) {
          this.$store.commit(`editor/${SET_FORM_PRIVATE}`)
        } else {
          this.$store.commit(`editor/${SET_FORM_PUBLIC}`)
        }
        this.save()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.editor-header {
  align-items: center;
  background: #fff;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  display: flex;
  justify-content: space-between;
  &__status {
    &__saved {
      animation: saved 3s linear both;

      @keyframes saved {
        from,
        90% {
          opacity: 1;
          visibility: visible;
        }
        to {
          opacity: 0;
          visibility: hidden;
        }
      }
    }
  }
}
</style>
