<?php

/**
 * Forms モデル
 */
class Forms_model extends MY_Model
{

  /**
   * 非公開のフォームをこのモデルの get の結果に含めるか
   * @var bool
   */
    public $include_private = false;

  /**
   * すべてのフォームを取得
   * @param  string   $period_type in_period(受付期間中), closed(受付終了), not_started(受付開始雨), null(全て) のいずれか
   * @return object[]              フォームオブジェクトの配列
   */
    public function get_forms($period_type = null)
    {
        if ($period_type === "in_period") {
            $where = "'". date("Y-m-d H:i:s"). "'". " BETWEEN open_at AND close_at";
            $this->db->where($where);
        } elseif ($period_type === "not_started") {
            $where = "'". date("Y-m-d H:i:s"). "'". " < open_at";
            $this->db->where($where);
        } elseif ($period_type === "closed") {
            $where = "'". date("Y-m-d H:i:s"). "'". " > close_at";
            $this->db->where($where);
        }

        if ($this->include_private !== true) {
            $this->db->where("is_public", 1);
        }

        $this->db->order_by("close_at");
        $query = $this->db->get("forms");
        $results = $query->result();
        for ($i = 0; $i < count($results); ++$i) {
            $results[$i] = $this->processing_form_data($results[$i]);
        }
        return $results;
    }

    public function get_form_by_form_id($form_id)
    {
        // フォーム情報を取得
        $this->db->where("id", $form_id);
        $form_info = $this->db->get("forms")->row();

        // 存在しないフォームの場合 false
        if (! $form_info) {
            return false;
        }

        $form_info->max_answers = (int)$form_info->max_answers;
        $form_info = $this->processing_form_data($form_info);

        // 非公開フォームだった場合 false
        if ($this->include_private !== true && $form_info->is_public !== true) {
            return false;
        }

        $select = [
            // form_questions
            "form_questions.id AS question_id",
            "form_questions.name AS question_name",
            "form_questions.description AS question_description",
            "form_questions.type AS question_type",
            "form_questions.is_required AS question_is_required",
            "form_questions.number_min AS question_number_min",
            "form_questions.number_max AS question_number_max",
            "form_questions.allowed_types AS question_allowed_types",
            "form_questions.max_size AS question_max_size",
            "form_questions.max_width AS question_max_width",
            "form_questions.max_height AS question_max_height",
            "form_questions.min_width AS question_min_width",
            "form_questions.min_height AS question_min_height",
            "form_questions.priority AS question_priority",
            // form_question_options
            "form_question_options.id AS option_id",
            "form_question_options.value AS option_value",
        ];
        $this->db->select(implode(",", $select), false);
        $this->db->where("form_questions.form_id", $form_id);
        $this->db->join("form_question_options", "form_questions.id = form_question_options.question_id", "left");
        $this->db->order_by("form_questions.priority");
        $query = $this->db->get("form_questions");
        $results = $query->result();

        // return 用の設問配列
        $questions_for_return = [];

        // 設問情報の中に、選択肢情報が入っている構造にする
        foreach ($results as $result) {
            // 設問オブジェクト
            $question_id = $result->id;
            if (empty($questions_for_return[$question_id])) {
                $question = new stdClass();
                $question->id = $result->question_id;
                $question->name = $result->question_name;
                $question->description = $result->question_description;
                $question->type = $result->question_type;
                $question->is_required = ((int)$result->question_is_required === 1);
                $question->number_min = $result->question_number_min ?? null;
                $question->number_max = $result->question_number_max ?? null;
                $question->allowed_types = $result->question_allowed_types;
                $question->max_size = (int)$result->question_max_size ?? null;
                $question->max_width = (int)$result->question_max_width ?? null;
                $question->max_height = (int)$result->question_max_height ?? null;
                $question->min_width = (int)$result->question_min_width ?? null;
                $question->min_height = (int)$result->question_min_height ?? null;
                $question->priority = (int)$result->question_priority ?? null;

                $questions_for_return[$question_id] = $question;
            }

            // 選択肢を格納していく
            if (! is_array($questions_for_return[$question_id]->options)) {
                $questions_for_return[$question_id]->options = [];
            }

            $option = new stdClass();

            $option->id = $result->option_id;
            $option->value = $result->value;

            $questions_for_return[$question_id]->options[] = $option;
        }

        $return = $form_info;
        $return->questions = $questions_for_return;

        return $return;
    }

  /**
   * 指定したフォームIDのフォームの統計情報を取得する
   * @param  int         $form_id フォームID
   * @return object|bool          統計情報オブジェクト．フォームが見つからない時 false
   */
    public function get_statistics_by_form_id($form_id)
    {
        $return = new stdClass();

        // フォーム情報を取得
        $form = $this->get_form_by_form_id($form_id);

        // 回答者数を取得
        // (回答者数 : typeがboothなら回答ブース数と回答団体数，circleなら回答団体数を取得．同じ団体が
        // 1つのフォームに対し2つ以上の回答をしていても，回答団体数は1とカウントする)
        $this->db->select(
            "count( DISTINCT circle_id ) AS count_circle, count( DISTINCT booth_id ) AS count_booth",
            false
        );
        $this->db->where("form_id", $form_id);
        $result = $this->db->get("form_answers")->row();
        if ($form->type === "circle") {
            // type が circle の場合
            $return->form_type = "circle";
            $return->count_circle = $result->count_circle;
            $return->count_booth = null;
            // 母数を取得する
            $return->count_all_circles = $this->circles->count_all();
            $return->count_all_booths = null;
            // 回答率を計算する
            $return->proportion_circle = round(( $return->count_circle / $return->count_all_circles ) * 100, 1);
            $return->proportion_booth = null;
        } else {
            // type が booth の場合
            $return->form_type = "booth";
            $return->count_circle = $result->count_circle;
            $return->count_booth = $result->count_booth;
            // 母数を取得する
            $return->count_all_circles = $this->circles->count_all();
            $return->count_all_booths = $this->booths->count_all();
            // 回答率を計算する
            $return->proportion_circle = round(( $return->count_circle / $return->count_all_circles ) * 100, 1);
            $return->proportion_booth = round(( $return->count_booth / $return->count_all_booths ) * 100, 1);
        }

        return $return;
    }

  /**
   * 指定した回答IDから回答を取得する
   * @param  int         $answer_id 回答ID( form_answers.id )
   * @return object|bool            回答オブジェクト。見つからない時 false
   */
    public function get_answer_by_answer_id($answer_id)
    {
      // form_answers
        $this->db->where("id", $answer_id);
        $answer = $this->db->get("form_answers")->row();
        if (!$answer) {
            return false;
        }

      // 団体情報とブース情報も取得
        $circle = $this->circles->get_circle_info_by_circle_id($answer->circle_id);
        $booth = null;
        if (!empty($answer->circle_id)) {
            $booth = $this->booths->get_booth_info_by_booth_id($answer->booth_id);
        }

      // form_answer_details
        $this->db->where("answer_id", $answer_id);
        $details = $this->db->get("form_answer_details")->result();
        $details_for_return = [];
        foreach ($details as $detail) {
            if (empty($details_for_return[ $detail->question_id ])) {
                $details_for_return[ $detail->question_id ] = $detail->answer;
            } else {
                if (!is_array($details_for_return[ $detail->question_id ])) {
                    $tmp = $details_for_return[ $detail->question_id ];
                    $details_for_return[ $detail->question_id ] = [];
                    $details_for_return[ $detail->question_id ][] = $tmp;
                }
                $details_for_return[ $detail->question_id ][] = $detail->answer;
            }
        }

        $return = $answer;
        $return->circle = $circle;
        $return->booth = $booth;
        $return->answers = $details_for_return;
        return $return;
    }

  /**
   * 指定した回答IDの回答の次の回答情報を取得する(ページング用，スタッフ用)
   * @param  int         $answer_id 回答ID
   * @param  int         $form_id   フォームID
   * @return object|bool            回答情報オブジェクト．存在しない場合 false
   */
    public function next_answer($answer_id, $form_id)
    {
        $this->db->select("id");
        $this->db->where("id >", $answer_id);
        $this->db->where("form_id", $form_id);
        $this->db->order_by("id", "asc");
        $this->db->limit(1);
        $query = $this->db->get("form_answers");
        if ($query->num_rows() === 1) {
            return $this->get_answer_by_answer_id($query->row()->id);
        } else {
            return false;
        }
    }

  /**
   * 指定した回答IDの回答の前の回答情報を取得する(ページング用，スタッフ用)
   * @param  int         $answer_id 回答ID
   * @param  int         $form_id   フォームID
   * @return object|bool            回答情報オブジェクト．存在しない場合 false
   */
    public function prev_answer($answer_id, $form_id)
    {
        $this->db->select("id");
        $this->db->where("id <", $answer_id);
        $this->db->where("form_id", $form_id);
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get("form_answers");
        if ($query->num_rows() === 1) {
            return $this->get_answer_by_answer_id($query->row()->id);
        } else {
            return false;
        }
    }

  /**
   * 検索条件に合致する回答リストを取得する
   * @param  int   $form_id   フォームID
   * @param  int   $circle_id 団体ID
   * @param  int   $booth_id  ブースID
   * @return array            リスト配列
   */
    public function get_answers($form_id = null, $circle_id = null, $booth_id = null)
    {
        if (!empty($form_id)) {
            $this->db->where("form_id", $form_id);
        }
        if (!empty($circle_id)) {
            $this->db->where("circle_id", $circle_id);
        }
        if (!empty($booth_id)) {
            $this->db->where("booth_id", $booth_id);
        }
        $query = $this->db->get("form_answers");

      // TODO: N+1問題の解決
        $return = [];
        foreach ($query->result() as $answer) {
            $item = $this->get_answer_by_answer_id($answer->id);
            $return[] = $item;
        }
        return $return;
    }

    public function get_options_by_question_id($question_id)
    {
        $this->db->where("question_id", $question_id);
        $query = $this->db->get("form_question_options");
        $return = [];
        foreach ($query->result() as $option) {
            $return[$option->id] = $option;
        }
        return $return;
    }

  /**
   * 回答を追加する
   * TODO: add_answer と update_answer の統合
   * @param array    $answers   回答情報
   * @param string   $type      circle か booth か
   * @param int      $form_id   フォームID
   * @param int      $circle_id 団体ID
   * @param int      $booth_id  ブースID
   * @param int|bool            insertした回答の回答ID．insertに失敗した場合 false
   */
    public function add_answer($answers, $type, $form_id, $circle_id, $booth_id)
    {
        $now = date("Y-m-d H:i:s");

        $this->db->trans_start();

      // form_answers に insert
        $this->db->set("form_id", $form_id);
        $this->db->set("created_at", $now);
        $this->db->set("modified_at", $now);
        $this->db->set("circle_id", $circle_id);
        if ($type === "booth") {
            $this->db->set("booth_id", $booth_id);
        }
        $this->db->insert("form_answers");

      // 回答ID
        $answer_id = $this->db->insert_id();

      // form_answer_details に insert
        foreach ($answers as $question_id => $answer) {
            if (is_array($answer)) {
                foreach ($answer as $option) {
                    $this->db->set("answer_id", $answer_id);
                    $this->db->set("question_id", $question_id);
                    $this->db->set("answer", $option);
                    $this->db->insert("form_answer_details");
                }
            } else {
                $this->db->set("answer_id", $answer_id);
                $this->db->set("question_id", $question_id);
                $this->db->set("answer", $answer);
                $this->db->insert("form_answer_details");
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return $answer_id;
    }

  /**
   * 回答を更新する
   * @param array $answers   回答情報
   * @param int   $answer_id 更新する回答の回答ID
   */
    public function update_answer($answers, $answer_id)
    {
        $now = date("Y-m-d H:i:s");

        $this->db->trans_start();

      // form_answers を update
        $this->db->where("id", $answer_id);
        $this->db->set("modified_at", $now);
        $this->db->update("form_answers");

      // form_answer_details を update
        foreach ($answers as $question_id => $answer) {
            if (is_array($answer)) {
                $this->db->where("answer_id", $answer_id);
                $this->db->where("question_id", $question_id);
                $this->db->delete("form_answer_details");
                foreach ($answer as $option) {
                    $this->db->set("answer_id", $answer_id);
                    $this->db->set("question_id", $question_id);
                    $this->db->set("answer", $option);
                    $this->db->insert("form_answer_details");
                }
            } else {
                $this->db->where("answer_id", $answer_id);
                $this->db->where("question_id", $question_id);
                $this->db->set("answer", $answer);
                $this->db->update("form_answer_details");
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return false;
        }

        return true;
    }

    private function processing_form_data($data)
    {
        $data->description_html = $this->parse_markdown($data->description);
        $data->open_at_string = $this->arrange_datetime($data->open_at, true);
        $data->close_at_string = $this->arrange_datetime($data->close_at, true);

        $data->is_public = ((int)$data->is_public === 1);
        // ↑ is_public === 1 なら true を代入

        // 受付期間内か
        $data->is_in_period = true;
        $data->now_period = "open";
        $now = new DateTime();
        $start_at_obj = new DateTime($data->open_at);
        $close_at_obj = new DateTime($data->close_at);
        if ($now < $start_at_obj) {
            $data->is_in_period = false;
            $data->now_period = "not_started";
        }
        if ($close_at_obj < $now) {
            $data->is_in_period = false;
            $data->now_period = "ended";
        }

        return $data;
    }
}
