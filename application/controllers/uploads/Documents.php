<?php
require_once __DIR__. '/Uploads_base_controller.php';

/**
 * uploads/Documents コントローラ
 */
class Documents extends Uploads_base_controller
{
    // このコードは、スタッフモードの「配布資料管理」ページからファイルをダウンロードする際に
    // アクセスされるので、スタッフモードの Laravel 化が完了するまで消さないこと
    public function index($document_id = null)
    {
        $document = $this->documents->get_document_by_document_id($document_id);

        if ($document !== false && !empty($this->_get_login_user()) && (int)$this->_get_login_user()->is_staff === 1) {
          // basename: ディレクトリ・トラバーサル脆弱性対策
            if (empty($document->filename)) {
                $this->_uploads_forbidden();
            }
            $filepath = PORTAL_UPLOAD_DIR. '/documents/'. basename($document->filename);

            $this->_render_file($filepath);
        } else {
            $this->_uploads_forbidden();
        }
    }
}
