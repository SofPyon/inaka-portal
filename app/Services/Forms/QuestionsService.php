<?php

declare(strict_types=1);

namespace App\Services\Forms;

use App\Eloquents\Form;
use App\Eloquents\Question;

class QuestionsService
{
    /**
     * 設問順序を更新する
     *
     * @param Form $form 変更したい設問が含まれているフォーム
     * @param array $priorities キーが設問IDで値がpriorityの配列
     */
    public function updateQuestionsOrder(Form $form, array $priorities)
    {
        foreach ($priorities as $question_id => $priority) {
            Question::where('id', $question_id)->where('form_id', $form->id)->update(['priority' => $priority]);
        }
    }
}