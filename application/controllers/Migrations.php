<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migrations extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('backend/Topic_model');
        $this->load->model('backend/Lesson_model');
        $this->load->model('backend/Level_model');
    }

    // Assign order to topics' lessons
	// public function index(){
    //     $topics = $this->Topic_model->gettopics();

    //     foreach ($topics as $topic) {
    //         $lessons = $this->Lesson_model->getLessons1(['topic_id' => $topic['topic_id']]);

    //         foreach ($lessons as $key => $lesson) {
    //             $this->Lesson_model->updateLesson($lesson['lesson_id'], ['lesson_order' => $key+1]);
    //         }
    //     }

	// 	echo 'Finished';
    // }
    
    // Assign order to levels
    // public function index(){
    //     $levels = $this->Level_model->getLevels1();

    //     foreach ($levels as $key => $level) {
    //         $this->Level_model->updateLevel($level['level_id'], ['level_order' => $key+1]);         
    //     }

	// 	echo 'Finished';
    // }
    
    // Ensure lessons belong to their topic's subjects

    public function index(){
        $topics = $this->Topic_model->gettopics();

        foreach ($topics as $topic) {
            $lessons = $this->Lesson_model->getLessons1(['topic_id' => $topic['topic_id']]);

            foreach ($lessons as $lesson) {
                $this->Lesson_model->updateLesson(
                    $lesson['lesson_id'],
                    ['subject_id' => $topic['subject_id']]
                );
            }
        }
        echo 'Finished';
    }

}
