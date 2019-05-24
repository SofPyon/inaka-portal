import Repository from './repository';

export default {
    get_form() {
        return Repository.get('get_form');
    },
    get_questions() {
        return Repository.get('get_questions');
    },
    update_questions_order(questions) {
        return Repository.post('update_questions_order', { questions });
    },
    update_question(question) {
        return Repository.post('update_question', { question });
    },
    update_form(form) {
        return Repository.post('update_form', { form });
    }
};
